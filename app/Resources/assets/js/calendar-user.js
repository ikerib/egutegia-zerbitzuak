/**
 * egutegia6
 * Created by iibarguren on 3/13/17.
 */

$(function () {
    var currentYear = new Date().getFullYear();
    var locale = $("#locale").val();

    $("#usercalendar").calendar({
        // style: 'background',
        language: locale,
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

    var getAjaxEvents = function () {
        var url = Routing.generate("get_events", { "calendarid": $("#calendarid").val() });
        return $.ajax({
            url: url,
            type: "GET",
            dataType: "json",
            success: function ( response ) {
                var data = [];
                if ( response.length > 0 ) {
                    for ( var i = 0; i < response.length; i++ ) {
                        var d = {};
                        d.id = response[i].id;
                        d.name = response[i].name;
                        if ( "type" in response[i] ) {
                            if ( "color" in response[i].type ) {
                                d.color = response[i].type.color;
                                d.type = response[i].type.id;
                            }
                        }
                        d.hours = parseFloat(response[i].hours);
                        d.startDate = new Date(response[i].start_date);
                        d.endDate = new Date(response[i].end_date);
                        data.push(d);
                    }
                }
                return data;
                // $('#calendar').data('calendar').setDataSource(data);
            },
            error: function () {
                return -1;
                console.log("HORROR!!");
            }

        });
    };

    var getAjaxTemplateEvents = function () {
        var tmpl = $("#templateid").val();
        if ( tmpl === -1 ) {
            console.log("ez du template-rik");
            return -1;
        }
        var url2 = Routing.generate("get_template_events", { "templateid": tmpl });
        return $.ajax({
            url: url2,
            type: "GET",
            dataType: "json",
            success: function ( response ) {
                var data = [];
                if ( response.length > 0 ) {
                    for ( var i = 0; i < response.length; i++ ) {
                        var d = {};
                        d.id = response[i].id;
                        d.name = response[i].name;
                        if ( "type" in response[i] ) {
                            if ( "color" in response[i].type ) {
                                d.color = response[i].type.color;
                                d.type = response[i].type.id;
                            }
                        }
                        d.hours = parseFloat(response[i].hours);
                        d.startDate = new Date(response[i].start_date);
                        d.endDate = new Date(response[i].end_date);
                        data.push(d);
                    }
                }
                // $('#calendar').data('calendar').setDataSource(data);
                return data;
            },
            error: function () {
                return -1;
            }

        });
    };

    $.when(getAjaxTemplateEvents(), getAjaxEvents()).done(function ( a1, a2 ) {
        var resp = [];
        // Check if template is set
        var tmpl = a1[0];

        if ( tmpl.length > 0 ) { // Template is set
            for ( var i = 0; i < tmpl.length; i++ ) {
                var d = {};
                d.id = tmpl[i].id;
                d.name = tmpl[i].name;
                if ( "type" in tmpl[i] ) {
                    if ( "color" in tmpl[i].type ) {
                        d.color = tmpl[i].type.color;
                        // d.color = '#3a4d57'
                        d.type = tmpl[i].type.id;
                    }
                }
                d.hours = parseFloat(tmpl[i].hours);
                d.startDate = new Date(tmpl[i].start_date);
                d.endDate = new Date(tmpl[i].end_date);
                d.istemplate = 1;

                resp.push(d);
            }
        }

        var eve = a2[0]; // Events
        for ( var j = 0; j < eve.length; j++ ) {
            var d2 = {};
            d2.id = eve[j].id;
            d2.name = eve[j].name;
            if ( "type" in eve[j] ) {
                if ( "color" in eve[j].type ) {
                    d2.color = eve[j].type.color;
                    d2.type = eve[j].type.id;
                }
            }
            d2.hours = parseFloat(eve[j].hours);
            d2.startDate = new Date(eve[j].start_date);
            d2.endDate = new Date(eve[j].end_date);
            d2.istemplate = 0;

            resp.push(d2);
        }

        $("#usercalendar").data("calendar").setDataSource(resp);

    });

});
