ymaps.ready(['Panel']).then(init);

var openPanelTypes = ['client12', 'client3', 'muff'];

var folderUrl = 'http://dev.oyster.su/maps/';

var apiUrl = folderUrl + "api.php";

var lineStyles = {
  air: {
    strokeColor: ['#0000ff', '#0000ff'],
    strokeWidth: 2,
    fillOpacity: 1
  },
  earth: {
    strokeColor: ['#000000', '#000000'],
    strokeWidth: 2,
    fillOpacity: 1
  }
}


function init() {
  var myMap = new ymaps.Map('map', {
    center: [59.9386300, 30.3141300], //Санкт-Петербург
    zoom: 11,
    controls: []
  }, {
    minZoom: 11,
    maxZoom: 18
  });

  var zoomControl = new ymaps.control.ZoomControl({
    options: {
      position: {
        left: 10,
        top: 208
      },
    }
  });

  myMap.controls.add(zoomControl);

  var searchControl = new ymaps.control.SearchControl({
    options: {
      provider: 'yandex#map',
      strictBounds: true,
      boundedBy: myMap.getBounds(),
      fitMaxWidth: true,
      maxWidth: [30, 72, 900],
      position: {
        top: 10,
        left: 10
      },
    }
  });
  myMap.controls.add(searchControl);

  var panel = new ymaps.Panel();
  myMap.controls.add(panel, {
    float: 'left'
  });

  var listBoxItemsLines = [{
        title: 'air',
        description: 'воздух'
      },
      {
        title: 'earth',
        description: 'земля'
      },
      {
        title: 'routes',
        description: 'маршруты'
      }
    ]
    .map(function (obj) {
      return new ymaps.control.ListBoxItem({
        data: {
          type: 'lines',
          content: obj.description,
          title: obj.title
        },
        state: {
          selected: true
        }
      })
    });


  var listBoxItems = [{
        title: 'muff',
        description: 'муфты'
      },
      {
        title: 'cross',
        description: 'кросс'
      },
      {
        title: 'client12',
        description: 'клиент12'
      },
      {
        title: 'client3',
        description: 'клиент3'
      },
      {
        title: 'ring',
        description: 'кольцо запаса'
      },
      {
        title: 'equipment',
        description: 'оборудование'
      },
      {
        title: 'post',
        description: 'стойки'
      }
    ]
    .map(function (obj) {
      return new ymaps.control.ListBoxItem({
        data: {
          type: 'objects',
          content: obj.description,
          title: obj.title
        },
        state: {
          selected: false
        }
      })
    }),
    listBoxControl = new ymaps.control.ListBox({
      data: {
        content: 'Фильтр',
        title: 'Фильтр'
      },
      items: listBoxItemsLines.concat(new ymaps.control.ListBoxItem({
        options: {
          type: 'separator'
        }
      }), listBoxItems),
      state: {
        // Признак, развернут ли список.
        expanded: false,
        filters: listBoxItemsLines.concat(listBoxItems).reduce(function (filters, filter) {
          filters[filter.data.get('title')] = {
            selected: filter.isSelected(),
            type: filter.data.get('type')
          }
          return filters;
        }, {})
      },
      options: {
        position: {
          right: 10,
          top: 10
        }
      }
    });

  Object.filter = function (obj, predicate) {
    var result = {},
      key;
    for (key in obj) {
      if (obj.hasOwnProperty(key) && !predicate(obj[key])) {
        result[key] = obj[key];
      }
    }
    return result;
  };

  // Добавим отслеживание изменения признака, выбран ли пункт списка.
  listBoxControl.events.add(['select', 'deselect'], function (e) {
    var listBoxItem = e.get('target');
    var filters = ymaps.util.extend({}, listBoxControl.state.get('filters'));
    filters[listBoxItem.data.get('title')] = {
      selected: listBoxItem.isSelected(),
      type: listBoxItem.data.get('type')
    };
    listBoxControl.state.set('filters', filters);
  });

  myMap.controls.add(listBoxControl);

  var filterMonitor = new ymaps.Monitor(listBoxControl.state);

  filterMonitor.add('filters', function (filters) {
    filterElements(filters);
  });


  function filterElements(filters){
    var zoom = myMap.getZoom();
    if (zoom < 16) {
      if (filters.air.selected) myMap.layers.add(imgLayerAir);
      else myMap.layers.remove(imgLayerAir);
      if (filters.earth.selected) myMap.layers.add(imgLayerEarth);
      else myMap.layers.remove(imgLayerEarth);
      if (filters.routes.selected) myMap.layers.add(imgLayerRoutes);
      else myMap.layers.remove(imgLayerRoutes);
    }
    remoteLineManager.setFilter(getFilterFunction(filters));
    remoteObjectManager.setFilter(getFilterFunction(filters));
  }

  function getFilterFunction(categories) {
    return function (obj) {
      var content = obj.properties.type;
      return categories[content].selected;
    }
  }


  // URL тайлов картиночного слоя.
  // Пример URL после подстановки -
  // '.../hotspot_layer/images/9/tile_x=1&y=2.png'.
  var imgUrlTemplateAir = folderUrl + 'tiles/air/%z/tile_%x_%y.png';
  var imgUrlTemplateEarth = folderUrl + 'tiles/earth/%z/tile_%x_%y.png';
  var imgUrlTemplateRoutes = folderUrl + 'tiles/routes/%z/tile_%x_%y.png';
  // var notFoundTile = folderUrl + 'tiles/tile_template.png';



  // Создаем картиночный слой и слой активных областей.
  var imgLayerAir = new ymaps.Layer(imgUrlTemplateAir, {
    tileTransparent: true
  });
  var imgLayerEarth = new ymaps.Layer(imgUrlTemplateEarth, {
    tileTransparent: true
  });
  var imgLayerRoutes = new ymaps.Layer(imgUrlTemplateRoutes, {
    tileTransparent: true
  });

  // Добавляем слои на карту.
  myMap.layers.add(imgLayerEarth);
  myMap.layers.add(imgLayerAir);
  myMap.layers.add(imgLayerRoutes);


  remoteLineManager = new ymaps.RemoteObjectManager(folderUrl + 'objects.php?cords=%b&type=lines', {});

  remoteObjectManager = new ymaps.RemoteObjectManager(folderUrl + 'objects.php?%c&type=objects', {
    splitRequests: true
  });

  remoteObjectManager.objects.events.add('click', function (e) {
    $('.customControl').css('display', 'none');
    var target = e.get('target');
    var objectId = e.get('objectId');
    //moveObject(objectId);
    var data = target._overlaysById[objectId]._data;
    if (openPanelTypes.indexOf(data.properties.type) !== -1) {
      myMap.balloon.close();
      myMap.balloon.events.fire('open');
      panel.setContent(data.properties.balloonContentBody);
    }
  });

/*
  remoteLineManager.objects.events.add('click', function (e) {
    var objectId = e.get('objectId');
    editLine(objectId);
  });

  var myPlacemark = new ymaps.Placemark([59.939580, 30.315885], {}, {
    iconLayout: 'default#image',
    iconImageHref: 'server.png',
    iconImageSize: [64, 64],
    iconImageOffset: [-32, -32]
  });

  myPlacemark.events.add('click', function (event) {
    var myPolyline = new ymaps.Polyline([
      [59.939580, 30.315885]
    ], {
      balloonContent: "Ломаная линия"
    }, {
      editorDrawingCursor: "crosshair",
      strokeColor: ["#000000", "#FFF", "#F00"],
      strokeWidth: [9, 8, 1],
      strokeStyle: [0, 0, 'dash']
    });
    myMap.geoObjects.add(myPolyline);
    var pointInobject = false;

    myPolyline.editor.startDrawing();

    myPolyline.editor.events.add(["beforevertexadd"], function (event) {
      var globalPixels = event.get("globalPixels");
      var projection = myMap.options.get('projection');
      var objects = remoteObjectManager.objects.getAll();
      var filterObjects = objects.filter(function (object) {
        var objectCoords = projection.toGlobalPixels(
          object.geometry.coordinates,
          myMap.getZoom()
        );
        return globalPixels[0] >= objectCoords[0] - 16 && globalPixels[1] >= objectCoords[1] - 32 &&
          globalPixels[0] <= objectCoords[0] + 16 && globalPixels[1] <= objectCoords[1]
      });
      var object = filterObjects[0] || null;
      if (object !== null) {
        var objectCoords = projection.toGlobalPixels(
          object.geometry.coordinates,
          myMap.getZoom()
        );
        event.callMethod("setGlobalPixels", objectCoords);
        pointInobject = true;
        myPolyline.editor.stopDrawing();
      }
    });

    myPolyline.editor.events.add('drawingstop', function (event) {
      if (pointInobject) {
        $('.modal').show();
        $('modal__title').text('Завершение линии')
        $('.modal__close').on('click', function (e) {
          e.preventDefault();
          if (confirm("Закрыть окно? Линия не сохранится")) {
            myMap.geoObjects.remove(myPolyline);
            $('.modal').hide();
          } else {
            return false;
          }
        });
        $('.modal__button-save').on('click', function (event) {
          var lineType = $('#lineType').val();
          remoteLineManager.objects.add({
            type: 'Feature',
            id: 'line' + Math.random(),
            geometry: {
              type: 'LineString',
              coordinates: myPolyline.geometry.getCoordinates()
            },
            properties: {
              type: lineType,
              hintContent: 'Содержание всплывающей подсказки',
              balloonContent: 'Содержание балуна'
            },
            options: {
              strokeColor: lineStyles[lineType].strokeColor,
              strokeWidth: lineStyles[lineType].strokeWidth,
              strokeOpacity: lineStyles[lineType].strokeOpacity
            }
          });
          myMap.geoObjects.remove(myPolyline);
          $('.modal').hide();
          $('.modal__button-save').unbind('click');
        });
        pointInobject = false;
      } else {
        alert('Объект не найден');
        myMap.geoObjects.remove(myPolyline);
        pointInobject = false;
      }
    });
  });

  myMap.geoObjects.add(myPlacemark);*/

  myMap.events.add('boundschange', function (event) {
    var oldZoom = event.get("oldZoom");
    var newZoom = event.get("newZoom");
    if (oldZoom < 16 && newZoom >= 16) {
      myMap.layers.remove(imgLayerEarth);
      myMap.layers.remove(imgLayerAir);
      myMap.layers.remove(imgLayerRoutes);
      myMap.geoObjects.add(remoteLineManager);
      myMap.geoObjects.add(remoteObjectManager);
      filterElements(listBoxControl.state.get('filters'));
    } else {
      if (newZoom < 16 && oldZoom >= 16) {
        if (listBoxControl.state.get('filters').earth.selected) myMap.layers.add(imgLayerEarth);
        if (listBoxControl.state.get('filters').air.selected) myMap.layers.add(imgLayerAir);
        if (listBoxControl.state.get('filters').routes.selected) myMap.layers.add(imgLayerRoutes);
        $('.customControl').css('display', 'none');
        myMap.geoObjects.remove(remoteObjectManager);
        myMap.geoObjects.remove(remoteLineManager);
      }
    }
  });

/*
  var MoveBegin = false;

  function moveObject(objectId) {
    if (!MoveBegin) {
      var object = remoteObjectManager.objects.getById(objectId);
      addToConsole("Начало перемещения " + objectId);
      MoveBegin = true;
      remoteObjectManager.objects.remove(object);
      myGeoObject = new ymaps.GeoObject({
        geometry: {
          type: "Point",
          coordinates: object.geometry.coordinates
        },
        properties: {}
      }, {
        preset: 'islands#icon',
        iconColor: '#0095b6',
        draggable: true
      })
      myMap.geoObjects.add(myGeoObject);
      $(".objectMoveInfo_wrapper").show();
      $("#objectMoveInfo_info").text(objectId);
      $(".objectMoveInfo_button").on("click", function () {
        var coords = myGeoObject.geometry.getCoordinates();
        sendAjax(apiUrl, {
          'op': 'setCoords',
          'id': objectId.slice(6),
          'lat': coords[0],
          'long': coords[1],
        }, function (answer) {
          if (answer === 'true') {
            $(".objectMoveInfo_wrapper").hide();
            $("#objectMoveInfo_info").text('');
            object.geometry.coordinates = coords;
            MoveBegin = false;
            myMap.geoObjects.remove(myGeoObject);
            remoteObjectManager.objects.add(object);
            addToConsole("Конец перемещения " + objectId);
            $('.objectMoveInfo_button').unbind('click');
          }
        });
      });
    }
  }


  var editLineBegin = false;

  function editLine(lineId) {
    if (!editLineBegin) {

      editLineBegin = true;
      addToConsole("Линия " + lineId);
      var line = remoteLineManager.objects.getById(lineId);

      remoteLineManager.objects.remove(line);

      var myPolyline = new ymaps.Polyline(line.geometry.coordinates, {
        balloonContent: "Ломаная линия"
      }, {
        draggable: true,
        strokeColor: ["#000000", "#FFF", "#F00"],
        strokeWidth: [9, 8, 1],
        strokeStyle: [0, 0, 'dash']
      });

      myMap.geoObjects.add(myPolyline);
      myPolyline.editor.startEditing();

      $(".objectMoveInfo_wrapper").show();
      $("#objectMoveInfo_info").text(lineId);
      $(".objectMoveInfo_button").on("click", function () {
        var coords = myPolyline.geometry.getCoordinates();

        sendAjax(apiUrl, {
          'op': 'setLineCoords',
          'id': lineId.slice(5),
          'coords': JSON.stringify(coords),
        }, function (answer) {
          if (answer === 'true') {
            $(".objectMoveInfo_wrapper").hide();
            $("#objectMoveInfo_info").text('');
            line.geometry.coordinates = coords;
            myMap.geoObjects.remove(myPolyline);
            remoteLineManager.objects.add(line);
            addToConsole("Конец перемещения " + lineId);
            editLineBegin = false;
            $('.objectMoveInfo_button').unbind('click');
          }
        });


      });
    }
  }*/

}

function sendAjax(url, data, callback, processData, contentType) {
  if (processData === undefined) processData = true;
  if (contentType === undefined) contentType = 'application/x-www-form-urlencoded; charset=UTF-8';
  $.ajax({
    type: 'post',
    url: url,
    data: data,
    processData: processData,
    contentType: contentType,
    success: function (answer) {
      if (answer === 'no-auth') {
        window.location.reload();
        return;
      }
      if (answer === 'permission denied') {
        return;
      }
      callback(answer);

    },
    error: function () {
      console.log("Ошибка сервера");
    }
  });
}


function addToConsole(text) {
  $(".myConsole").html($(".myConsole").html() + text + "<br/>");
}