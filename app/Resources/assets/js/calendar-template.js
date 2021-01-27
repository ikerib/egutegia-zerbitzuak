/**
 * Egutegia3
 * Created by iibarguren on 3/13/17.
 */
$(function () {

    function editEvent( event ) {
        $("#event-modal input[name=\"event-index\"]").val(event ? event.id : "");
        $("#event-modal input[name=\"event-name\"]").val(event ? event.name : "");
        $("#event-modal input[name=\"event-type\"]").val(event ? event.type : "");
        $("#event-modal input[name=\"event-start-date\"]").datepicker("update", event ? event.startDate : "");
        $("#event-modal input[name=\"event-end-date\"]").datepicker("update", event ? event.endDate : "");
        $("#event-modal").modal();
        $("#event-modal").on("shown.bs.modal", function () {
            $("#event-modal input[name=\"event-name\"]").focus();
        });
    }

    function deleteEvent( event ) {
        var dataSource = $("#admincalendar").data("calendar").getDataSource();

        for ( var i in dataSource ) {
            if ( dataSource[i].id == event.id ) {
                dataSource.splice(i, 1);
                break;
            }
        }

        $("#admincalendar").data("calendar").setDataSource(dataSource);
    }

    function saveEvent() {
        var event = {
            id: $("#event-modal input[name=\"event-index\"]").val(),
            name: $("#event-modal input[name=\"event-name\"]").val(),
            type: $("#event-modal option:selected").val(),
            color: $("#event-modal option:selected").data("color"),
            startDate: $("#event-modal input[name=\"event-start-date\"]").datepicker("getDate"),
            endDate: $("#event-modal input[name=\"event-end-date\"]").datepicker("getDate")
        };

        var dataSource = $("#admincalendar").data("calendar").getDataSource();

        if ( event.id ) {
            for ( var i in dataSource ) {
                if ( dataSource[i].id === event.id ) {
                    dataSource[i].name = event.name;
                    dataSource[i].type = event.type;
                    dataSource[i].color = event.color;
                    dataSource[i].startDate = event.startDate;
                    dataSource[i].endDate = event.endDate;
                }
            }
        } else {
            var newId = 0;
            for ( var i in dataSource ) {
                if ( dataSource[i].id > newId ) {
                    newId = dataSource[i].id;
                }
            }

            newId++;
            event.id = newId;

            dataSource.push(event);
        }

        $("#admincalendar").data("calendar").setDataSource(dataSource);
        $("#event-modal").modal("hide");
    }

    var currentYear = new Date().getFullYear();

    $("#admincalendar").calendar({
        style: "background",
        language: "eu",
        minDate: new Date("2017-01-01"),
        allowOverlap: true,
        // displayWeekNumber: true,
        enableContextMenu: true,
        enableRangeSelection: true,
        contextMenuItems: [
            {
                text: "Eguneratu",
                click: editEvent
            },
            {
                text: "Ezabatu",
                click: deleteEvent
            }
        ],
        selectRange: function ( e ) {
            editEvent({ startDate: e.startDate, endDate: e.endDate });
        },
        mouseOnDay: function ( e ) {
            if ( e.events.length > 0 ) {
                var content = "";

                for ( var i in e.events ) {
                    content += "<div class=\"event-tooltip-content\">"
                        + "<div class=\"event-name\" style=\"color:" + e.events[i].color + "\">" + e.events[i].name + "</div>"
                        // + '<div class="event-type">' + e.events[i].type + '</div>'
                        + "</div>";
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
        },
        dayContextMenu: function ( e ) {
            $(e.element).popover("hide");
        }
    });

    var url = Routing.generate("get_template_events", { "templateid": $("#templateid").val() });

    $.ajax({
        url: url,
        type: "GET",
        dataType: "json",
        success: function ( response ) {
            var data = [];
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
                // d.hours = parseFloat(tmpl[i].hours);
                d.startDate = new Date(response[i].start_date);
                d.endDate = new Date(response[i].end_date);
                d.istemplate = 1;

                data.push(d);
            }
            $("#admincalendar").data("calendar").setDataSource(data);
        }

    });

    $("#save-event").click(function () {
        saveEvent();
    });

    $("#btnGrabatu").on("click", function () {
        var templateid = $("#templateid").val();
        var akatsa = 0;

        var funcDeleteTemplateEvents = function () {

            var url = Routing.generate("delete_template_events", { "templateid": templateid });
            return $.ajax({
                url: url,
                type: "DELETE"
            }).done(function ( data, textStatus, jqXHR ) {
                return jqXHR.status; //handle your 204 or other status codes here
            }).fail(function () {
                akatsa = 1;
                return -1;
            });
        };

        var funcSaveTemplateEvents = function () {
            var aka = 0;
            var datuak = $("#admincalendar").data("calendar").getDataSource();
            for ( var i = 0; i < datuak.length && aka === 0; i++ ) {

                var url = Routing.generate("post_template_events");

                var d = {};
                d.templateid = $("#templateid").val();
                d.name = datuak[i].name;
                d.startDate = moment(datuak[i].startDate).format("YYYY-MM-DD");
                d.endDate = moment(datuak[i].endDate).format("YYYY-MM-DD");
                d.color = datuak[i].color;
                if ( typeof (datuak[i].type) === "object" ) {
                    d.type = datuak[i].type.id;
                } else {
                    d.type = datuak[i].type;
                }

                $.ajax({
                    url: url,
                    async: false,
                    type: "POST",
                    data: JSON.stringify(d),
                    contentType: "application/json",
                    dataType: "json",
                    success: function ( e ) {
                        return 1;
                    }
                }).fail(function ( xhr, status, error ) {
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
                    aka = 1;
                    akatsa = 1;
                    return -1;
                });
            }

            if ( aka === 0 ) {
                return 1;
            } else {
                return -1;
            }

        };
        $.when(funcDeleteTemplateEvents(), funcSaveTemplateEvents()).done(function ( a1, a2 ) {
            $("#myAlert").hide();
            $("#alertSpot").empty();
            if ( a2 === -1 ) {
                $("#alertSpot").append(
                    "<div id=\"myAlert\" class=\"alert alert-danger alert-dismissible\" role=\"alert\">" +
                    "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>" +
                    "<strong>Arazo</strong> bat egon da eta datuak ezin izan dira grabatu.");
            } else {
                $("#alertSpot").append(
                    "<div id=\"myAlert\" class=\"alert alert-success alert-dismissible\" role=\"alert\">" +
                    "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>" +
                    "Datuak <strong>ongi</strong> grabatuak izan dira.");
            }


            $("#myAlert").alert();
            $("#myAlert").fadeTo(2000, 500).slideUp(500, function () {
                $("#myAlert").slideUp(500);
            });
        });

    });

});
