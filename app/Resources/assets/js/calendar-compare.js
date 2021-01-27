/**
 * egutegia7
 * Created by iibarguren on 3/13/17.
 */

$(function () {
  var currentYear = new Date().getFullYear();

  $("#compareCalendar").calendar({
    // style: 'background',
    language: "eu",
    minDate: new Date("2017-01-01"),
    allowOverlap: true,
    enableContextMenu: false,
    enableRangeSelection: false,
    mouseOnDay: function ( e ) {
      if ( e.events.length > 0 ) {
        var content = "";

        for ( var i in e.events ) {
          content += "<div class=\"event-tooltip-content\">"
            + "<div class=\"event-name\" style=\"color:" + e.events[i].color + "\">" + e.events[i].name + "</div>";

          if ( e.events[i].hours ) {
            content += "<div class=\"event-type\">" + e.events[i].hours + "</div>";
          }

          content += "</div>";
        }

        $(e.element).popover({
          trigger: "manual",
          container: "body",
          html: true,
          content: content
        });

        $(e.element).popover("show");
      }
    },
    mouseOutDay: function ( e ) {
      if ( e.events.length > 0 ) {
        $(e.element).popover("hide");
      }
    }
  });

  var calendarData = $.parseJSON($("#calendarData").val());
  var data = [];
  console.log(data);

  for ( var j = 0; j < calendarData.length; j++ ) {
    var d = {};
    var eve = calendarData[j];

    d.id = eve.id;
    d.name = eve.name;
    d.color = eve.color;
    d.hours = parseFloat(eve.hours);
    d.startDate = new Date(eve.startDate);
    d.endDate = new Date(eve.endDate);
    d.istemplate = 0;

    data.push(d);

  }

  $("#compareCalendar").data("calendar").setDataSource(data);


});
