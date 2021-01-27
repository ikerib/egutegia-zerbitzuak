/**
 * Created by iibarguren on 3/13/17.
 */

$(document).ready(function () {

    $(document).on("mouseenter", ".page-header", function () {
        $(".btnPageHeaderEdit").show();
        $(".btnEzabatu").show();
    }).on("mouseleave", ".page-header", function () {
        $(".btnPageHeaderEdit").hide();
        $(".btnEzabatu").hide();
    });

    $('#btnGorde').on('click', function () {
        $('form').submit()
    });

    $('#btnGordeModal').on('click', function () {
        $('form').submit()
    });

    $('.btnPageHeaderEdit').on('click', function () {
        $('#edit-modal').modal()
    });

    $(".dropdown-toggle").dropdown();

    /*****************************************************************************************************************/
    /** ESKAERA NEW  *************************************************************************************************/
    /*****************************************************************************************************************/


    $('#fetxa-inline').datepicker({
        format: "yyyy-mm-dd",
        language: "eu"
    }).on('changeDate', function(event) {
        $('#appbundle_konpentsatuak_fetxa').val(event.format('yyyy-mm-dd'));
    });

    $('#appbundle_konpentsatuak_fetxa').datepicker({
        format: "yyyy-mm-dd",
        language: "eu",
        orientation: "bottom left",
        todayHighlight: true,
        autoclose: true
    });






    /*****************************************************************************************************************/
    /** FIN ESKAERA NEW  *********************************************************************************************/
    /*****************************************************************************************************************/

    /*****************************************************************************************************************/
    /** NOTIFICATION INDEX  ******************************************************************************************/
    /*****************************************************************************************************************/
    $('.btnReaded').on('click', function () {
        const that = this;
        const miid = $(this).data('id')
        const url = Routing.generate('put_jakinarazpena_readed', {'id': miid})
        $.ajax({
            url: url,
            method: 'PUT'
        })
            .done(function (data) {
                if ($(that).children().hasClass('label-danger')) {
                    $(that).html(' <span class="label label-success"> Bai</span>')
                } else {
                    $(that).html(' <span class="label label-danger"> Ez</span>')
                }
            })
            .fail(function (xhr) {
                bootbox.alert('Akats bat gertatu da.')
            })
    })

    $(document).on('click', '.btnEskaeraOnartu', function() {
        const firmaid = $(this).data("firmaid");
        const jakinarazpenaid = $(this).data("notifyid");
        const userid = null;
        const url = Routing.generate("put_firma", { "id": firmaid, "userid": null });
        const $tr = $(this).closest('tr'); //here we hold a reference to the clicked tr which will be later used to delete the row
        const nexttr = $(this).closest("tr").next("tr");

        $.ajax({
            url: url,
            method: 'PUT',
            data: {onartua: 1}
        })
            .done(function (data) {
              const numNotificationsLeft = data.notifications.length;
              $("#mainMenuNotificationCount").text(numNotificationsLeft);
              $('#subMenuNotificationCount').text(numNotificationsLeft);

              if ( $(nexttr).hasClass('detail-view') ) {
                nexttr.find('td').fadeOut(1000,function(){
                  nexttr.remove();
                });
              }
              $tr.find('td').fadeOut(1000,function(){
                  $tr.remove();
              });
            })
            .fail(function (xhr) {
                bootbox.alert('Akats bat gertatu da firmatzerakoan.')
            });
    });

    $('.btnEskaeraEzOnartu').on('click', function () {
        const firmaid = $(this).data('firmaid');
        const jakinarazpenaid = $(this).data('notifyid');
        const url = Routing.generate('put_firma', {'id': firmaid});
        const $tr = $(this).closest('tr'); //here we hold a reference to the clicked tr which will be later used to delete the row

        $.ajax({
            url: url,
            method: 'PUT',
            data: {onartua: 0}
        })
            .done(function (data) {
                const url2 = Routing.generate('put_jakinarazpena', {'id': jakinarazpenaid});
                $.ajax({
                    url: url2,
                    method: 'PUT',
                    data: {onartua: 0}
                }).done(function (data) {
                    $tr.find('td').fadeOut(1000,function(){
                        $tr.remove();
                    });
                }).fail(function (xhr) {
                    bootbox.alert('Firma egin da baina jakinarazpena irakurria markatzerakoan akatsa bat gertatu da.')
                })
            })
            .fail(function (xhr) {
                bootbox.alert('Akats bat gertatu da firmatzerakoan.')
            })
    });
    /*****************************************************************************************************************/
    /** FIN NOTIFICATION INDEX  **************************************************************************************/
    /*****************************************************************************************************************/


});
