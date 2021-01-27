/**
 * egutegia5
 * Created by iibarguren on 6/7/17.
 */

$(function () {

    $("#event-modal").draggable({ handle: ".modal-header" });

  /*************************************************************************************************************/
  /** MISC *****************************************************************************************************/
  /*************************************************************************************************************/
  let x = parseFloat($('#numberLanaldi').val())
  let textua = ' ( ' + moment.duration(x, 'hours').hours() + ' ordu ' + moment.duration(x, 'hours').minutes() + ' minutu )'
  $('#hourLanaldi').text(textua)

  let x1 = parseFloat($('#numberHoursPartial').val())
  let textua1 = " ( " + moment.duration(x1, 'hours').hours() + ' ordu ' + moment.duration(x1, 'hours').minutes() +  " minutu )"
  $('#selfHoursPartialToHour').text(textua1)

  /*************************************************************************************************************/
  /** HASH funtzioak *******************************************************************************************/
  /*************************************************************************************************************/
  let url = document.location.toString()
  if (url.match('#')) {
    $('.nav-tabs a[href="#' + url.split('#')[1] + '-tab"]').tab('show')
  }

  // Change hash for page-reload
  $('.nav-tabs a').on('shown.bs.tab', function (e) {
    e.preventDefault()
    window.location.hash = '!' + e.target.hash
    return false
  })

  // show specific tab
  let hash = window.location.hash
  hash = window.location.hash.replace(/^#!/, '')
  $('#myTab a[href="' + hash + '"]').tab('show')


  /*************************************************************************************************************/
  /** Egutegia Tab *********************************************************************************************/
  /*************************************************************************************************************/
  $('#save-calendar-note').on('click', function () {
    let calendarid = $('#calendarid').val()
    let url = Routing.generate('post_notes', {'calendarid': calendarid})

    let values = {}
    $.each($('#frmNotes').serializeArray(), function (i, field) {
      values[field.name] = field.value
    })

    $.ajax({
      url: url,
      data: values,
      type: 'POST',
      success: function () {
        $('#myAlert').hide()
        $('#alertSpot').empty()
        $('#alertSpot').append(
          '<div id="myAlert" class="alert alert-success alert-dismissible" role="alert">' +
          '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
          'Datuak <strong>ongi</strong> grabatuak izan dira.')

        $('#myAlert').alert()
        $('#myAlert').fadeTo(2000, 500).slideUp(500, function () {
          $('#myAlert').slideUp(500)
        })
      }
    })
  })

  $('#saveCalendarEditModal').on('click', function () {
    $('#frmEditCalendar').submit()
  })

  /*************************************************************************************************************/
  /** Fitxategiak Tab ******************************************************************************************/
  /*************************************************************************************************************/
  $('.btnRemoveRow').on('click', function () {
    let that = $(this)
    bootbox.confirm({
      title: 'Adi!',
      message: 'Ziur zaude ezabatu nahi duzula?',
      buttons: {
        cancel: {
          label: '<i class="fa fa-times"></i> Ezeztatu'
        },
        confirm: {
          label: '<i class="fa fa-check"></i> Onartu'
        }
      },
      callback: function (result) {
        if (result === true) {
          $(that).closest('form').submit()
        }
      }
    })
  })

  $('#save-upload-file').on('click', function () {
    $('#frmFile').submit()
  })


  /*************************************************************************************************************/
  /** Konpentsatuak Tab ******************************************************************************************/
  /*************************************************************************************************************/
  $('#btnAddKonpentsatua').click(function () {
    $('#modal-content-konpentsatuak').empty()

    let calendarid = $('#calendarid').val()
    let url = Routing.generate('admin_hour_new', {'calendarid': calendarid})
    $('#modal-content-konpentsatuak').load(url, function () {
      $('#modal-konpentsatuak').modal()
      $('#appbundle_hour_date').datepicker({
        format: 'yyyy-mm-dd',
        language: 'eu'
      });
    });
  })

  $('.btn-edit-konpentsatua').click(function () {
    $('#modal-content-konpentsatuak').empty()

    let miid = $(this).data('id')
    let url = Routing.generate('admin_hour_edit', {'id': miid })
    $('#modal-content-konpentsatuak').load(url, function () {
      $('#modal-konpentsatuak').modal()
    });
  })

  $(document).on('click', '#save-konpentsatua', function () {
    $('#frmaddkonpentsatua').submit()
  })

  $('#btnModalOpenFile').on('click', function() {
    $('#modal-files-open').modal('show');
  });

  $(document).on('click', '.btnRemoveHourwRow', function () {
    let that = $(this)
    bootbox.confirm({
      title: 'Adi!',
      message: 'Ziur zaude ezabatu nahi duzula?',
      buttons: {
        cancel: {
          label: '<i class="fa fa-times"></i> Ezeztatu'
        },
        confirm: {
          label: '<i class="fa fa-check"></i> Onartu'
        }
      },
      callback: function (result) {
        if (result === true) {
          $(that).closest('form').submit()
        }
      }
    })
  })

  $(document).on('change', '.birkalk', function () {
    birKalkulatu()
  })

  function birKalkulatu() {
    let iHour = $('#appbundle_hour_hours').val().replace(/\,/g, '.')
    if (iHour.length === 0) { iHour = 0 }
    if (!$.isNumeric(iHour)) { iHour = 0 }
    let fHour = parseFloat( iHour)

    let iMinu = $('#appbundle_hour_minutes').val().replace(/\,/g, '.')
    if (iMinu.length === 0) { iMinu = 0 }
    if (!$.isNumeric(iMinu)) { iMinu = 0 }
    let fMinu = parseFloat(iMinu)

    let iFact = $('#appbundle_hour_factor').val().replace(/\,/g, '.')
    if (iFact.length === 0) { iFact = 0 }
    if (!$.isNumeric(iFact)) { iFact = 0 }
    let fFact = parseFloat(iFact)

    let dest  = $('#appbundle_hour_total');

    let tempOrduak = fHour + parseFloat( fMinu / 60)
    dest.val( parseFloat(tempOrduak * fFact).toFixed(2) )

  }

})