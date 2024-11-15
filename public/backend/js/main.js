var url = $('meta[name="base-url"]').attr("content");
// tokens
var _token = $('meta[name="csrf-token"]').attr("content");
// global delete method where we try to use this for every delete
var currency_symbol = $("#currency_symbol").val();
window.onload = function () {
  $(".daterangepicker").css("display", "none");
};
$(".daterangepicker").on("click", function () {
  $(this).css("display", "block");
});
//swal toaster
const Toast = Swal.mixin({
  toast: true,
  position: "top-right",
  animation: false,
  iconColor: "white",
  customClass: {
    popup: "colored-toast",
  },
  showConfirmButton: false,
  timer: 1500,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.addEventListener("mouseenter", Swal.stopTimer);
    toast.addEventListener("mouseleave", Swal.resumeTimer);
  },
});

__globalDelete = (id, ur) => {
  Swal.fire({
    title: $('#are_you_sure').val(),
    text: $('#you_want_delete').val(),
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: "Delete",
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = `${url + "/" + ur + id}`;
    } else if (result.dismiss === Swal.DismissReason.cancel) {
      // Swal.fire(
      //     'Cancelled',
      //     'Your file is safe :)',
      //     'error'
      // )
    }
  });
};
__deleteAlert = (ur) => {
  Swal.fire({
    title: $("#are_you_sure").val(),
    text: "",
    icon: "error",
    showCancelButton: true,
    confirmButtonText: $("#yes").val(),
    cancelButtonText: $("#cancel").val(),
    reverseButtons: true,
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = ur;
    } else if (result.dismiss === Swal.DismissReason.cancel) {
      // Swal.fire(
      //     'Cancelled',
      //     'Your file is safe :)',
      //     'error'
      // )
    }
  });
};

GlobalApproveId = (id, ur, title) => {
  Swal.fire({
    title: "Are you sure?",
    icon: "success",
    showCancelButton: true,
    confirmButtonText: title,
    cancelButtonText: "Cancel",
    reverseButtons: true,
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = `${url + "/" + ur + id}`;
    } else if (result.dismiss === Swal.DismissReason.cancel) {
      Swal.fire("Cancelled");
    }
  });
};

GlobalApprove = (ur, title) => {
  Swal.fire({
    title: "Are you sure?",
    icon: "success",
    showCancelButton: true,
    confirmButtonText: title,
    cancelButtonText: "Cancel",
    reverseButtons: true,
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = ur;
    } else if (result.dismiss === Swal.DismissReason.cancel) {
      Swal.fire("Cancelled");
    }
  });
};

ApproveOrReject = (id, status, ur, title) => {
  Swal.fire({
    title: "Are you sure?",
    icon: "success",
    showCancelButton: true,
    confirmButtonText: "Yes",
    cancelButtonText: "No",
    reverseButtons: true,
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = `${url + "/" + ur + id + "/" + status}`;
    } else if (result.dismiss === Swal.DismissReason.cancel) {
      // Swal.fire(
      //     'Cancelled',
      // )
    }
  });
};

GlobalSweetAlert = (title, text, icon, button, go_url) => {
  Swal.fire({
    title: title,
    text: text,
    icon: icon,
    showCancelButton: true,
    confirmButtonText: button,
    cancelButtonText: $("#cancel").val(),
    reverseButtons: true,
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = go_url;
    } else if (result.dismiss === Swal.DismissReason.cancel) {
    }
  });
};

function GlobalSweetAlertForLocation(title, text, icon, confirmButtonText, route) {
  Swal.fire({
      title: title,
      text: text,
      icon: icon,
      showCancelButton: true,
      confirmButtonText: confirmButtonText,
      cancelButtonText: 'Cancel',
      showLoaderOnConfirm: true,
      preConfirm: () => {
          return fetch(route, {
              method: 'POST',
              headers: {
                  'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                  'Accept': 'application/json',
              },
          })
              .then(response => {
                  if (!response.ok) {
                      throw new Error(response.statusText);
                  }
                  return response.json();
              })
              .catch(error => {
                  Swal.showValidationMessage(`Request failed: ${error}`);
              });
      },
  }).then(result => {
      if (result.isConfirmed) {
          Swal.fire('Success!', 'Location status has been updated.', 'success');
          location.reload(); // Optional: Reload the page
      }
  });
}


MakeHrByAdmin = (id, status, ur, title) => {
  let new_url = `${url + "/" + status + id}`;
  // console.log(new_url);

  Swal.fire({
    title: "Are you sure?",
    icon: "success",
    showCancelButton: true,
    confirmButtonText: "Yes",
    cancelButtonText: "No",
    reverseButtons: true,
  }).then((result) => {
    if (result.isConfirmed) {
      // window.location.href = new_url;
    } else if (result.dismiss === Swal.DismissReason.cancel) {
      // Swal.fire(
      //     'Cancelled',
      // )
    }
  });
};
var modalClose = (event) => {
  $(".modal").remove();
  $(".modal-barkdrop").remove();
  $(".modal-backdrop").remove();
  $(".modal-open").removeClass("modal-open");
  $(".modal-backdrop").removeClass("modal-backdrop");
  $(".modal-backdrop").removeClass("modal-backdrop-open");
  $(".modal-backdrop").removeClass("show");
};

viewModal = (ur) => {
  modalClose();
  $.get(ur, function (data) {
    if (data == "fail") {
      setTimeout(function () {
        toastr.error("Something went wrong!", "Error!", {
          timeOut: 2000,
        });
      }, 500);
    } else {
      $(data).appendTo("body");
      $(".modal").modal("show");
    }
  });
};

Reject = (id, ur) => {
  var html = `<div class="modal modal-blur fade" id="delete" tabindex="-1" role="dialog" aria-hidden="true">
           <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
               <div class="modal-content">
                 <div class="modal-body">
                   <div class="modal-title">
                   <h1 class="text-center danger"><i class="fas fa-exclamation-circle"></i></h1>
                   <br>
                   <h3 class="text-center">Are you sure?</h3> </div>
                 </div>
                 <div class="modal-footer">
                   <button type="button" class="btn btn-link btn-default mr-auto" data-dismiss="modal">Cancel</button>
                   <a href="${
                     url + "/" + ur + id
                   }" class="btn btn-danger">Reject</a>
                 </div>
               </div>
           </div>
         </div>`;
  $(html).appendTo("body").modal();
};

Approve = (id, ur) => {
  var html = `<div class="modal modal-blur fade" id="delete" tabindex="-1" role="dialog" aria-hidden="true">
           <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
               <div class="modal-content">
                 <div class="modal-body">
                   <div class="modal-title">
                   <h1 class="text-center text-success"><i class="far fa-check-circle"></i></h1>
                   <br>
                   <h3 class="text-center">Are you sure?</h3> </div>
                 </div>
                 <div class="modal-footer">
                   <button type="button" class="btn btn-link btn-default mr-auto" data-dismiss="modal">Cancel</button>
                   <a href="${
                     url + "/" + ur + id
                   }" class="btn btn-primary">Approve</a>
                 </div>
               </div>
           </div>
         </div>`;
  $(html).appendTo("body").modal();
};
Complete = (id, ur) => {
  var html = `<div class="modal modal-blur fade" id="delete" tabindex="-1" role="dialog" aria-hidden="true">
           <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
               <div class="modal-content">
                 <div class="modal-body">
                   <div class="modal-title">
                   <h1 class="text-center text-success"><i class="far fa-check-circle"></i></h1>
                   <br>
                   <h3 class="text-center">Are you sure?</h3> </div>
                 </div>
                 <div class="modal-footer">
                   <button type="button" class="btn btn-link btn-default mr-auto" data-dismiss="modal">Cancel</button>
                   <a href="${
                     url + "/" + ur + id
                   }" class="btn btn-primary">Complete</a>
                 </div>
               </div>
           </div>
         </div>`;
  $(html).appendTo("body").modal();
};
$(".select2").select2({
  placeholder: "Choose one",
  width: "100%",
});
// $('select').select2({
//     placeholder: 'Choose one',
// })
// $(document).ready(function () {
//     var t = $('#summernote').summernote(
//         {
//             height: 200,
//             focus: true
//         }
//     );
//     $("#btn").on("click",function () {
//         $('div.note-editable').height(150);
//     });
// });
// $(document).ready(function () {
//     var t = $('.summernote').summernote(
//         {
//             height: 200,
//             focus: true
//         }
//     );
//     $("#btn").on("click",function () {
//         $('div.note-editable').height(150);
//     });
// });

$("#terms_check_make_parent").on("click", function () {
  if ($(this).prop("checked")) {
    $("#terms_check_make_button").prop("disabled", false);
  } else {
    $("#terms_check_make_button").attr("disabled", true);
  }
});

accountStatement = () => {
  $.ajax({
    type: "POST",
    dataType: "html",
    data: {
      start_date: $("#start_date").val(),
      end_date: $("#end_date").val(),
      _token: _token,
    },
    url: url + "/" + "dashboard/reports/ajax-account-statement",
    success: function (data) {
      $("#__account_statement").html(data);
    },
    error: function (data) {},
  });
};

$("#__account_statement").length > 0 && accountStatement();

//show leave type modal

//status updating for vehicle
$("body").on("click", ".statusActionBtn", function () {
  let id = $(this).attr("item-id");
  let url = `vehicle/update-status/${id}`;
  console.log(url);
  $.ajax({
    type: "GET",
    url: url,
    success: function (data) {
      window.location.reload();
    },
    error: function (data) {
      console.log(data);
    },
  });
});

$(".upload_file").length > 0
  ? (upload_file.onchange = (evt) => {
      const [file] = upload_file.files;
      if (file) {
        bruh.src = URL.createObjectURL(file);
      }
    })
  : "";

//get department wise user
function selectDepartmentUsers() {
  let department_id = $("#department").select2("val");
  $("#selected_department").val(department_id);
  $("#__user_id").select2({
    placeholder: "Choose User",
    ajax: {
      url: url + "/dashboard/user/get-all-user-by-dep-des",
      data: {
        department_id: department_id,
        _token: _token,
      },
      type: "POST",
      delay: 250,
      processResults: function (data) {
        let users = data.data.users;
        return {
          results: $.map(users, function (item) {
            return {
              text: item.name,
              id: item.id,
            };
          }),
        };
      },
      cache: false,
    },
  });
}



//get department wise user (department filter also)  // payroll salary advance
function selectDepartmentUsersAll() {
  salaryAdvanceDatatable();
  departmentWiseUsers();
}
//get department wise user end (department filter also)

//get department wise user (department filter also)  // leave request
function selectLeaveRequestDepartmentUsers() {
  leaveRequestDatatable();
  departmentWiseUsers();
}
//get department wise user end (department filter also)

//get department wise user (department filter also)  // manage visit
function selectVisitDepartmentUsers() {
  visitDatatable();
  departmentWiseUsers();
}
//get department wise user end (department filter also)

//get department wise user (department filter also)  // break history
function selectBreakHistoryDepartmentUsers() {
  breakTable();
  departmentWiseUsers();
}
//get department wise user end (department filter also)

//get department wise user (department filter also)  // visit reports
function selectVisitReportDepartmentUsers() {
  visitReportDatatable();
  departmentWiseUsers();
}
//get department wise user end (department filter also)

// department wise users 
function departmentWiseUsers() {
  let department_id = $("#department_id").select2("val");
  $("#selected_department").val(department_id);
  $("#__user_id").select2({
    placeholder: "Choose User",
    ajax: {
      url: url + "/dashboard/user/get-all-user-by-dep-des",
      data: {
        department_id: department_id,
        _token: _token,
      },
      type: "POST",
      delay: 250,
      processResults: function (data) {
        let users = data.data.users;
        return {
          results: $.map(users, function (item) {
            return {
              text: item.name,
              id: item.id,
            };
          }),
        };
      },
      cache: false,
    },
  });
}

//Get Users

$("#user_id").select2({
  placeholder: "Choose Employee",
  placement: "bottom",
  ajax: {
    url: $("#get_custom_user_url").val(),
    dataType: "json",
    data: function (params) {
      return {
        _token: _token,
        term: params.term, // Pass the typed value as the 'term' parameter
      };
    },
    type: "POST",
    delay: 250,
    processResults: function (data) {
      return {
        results: $.map(data, function (item) {
          return {
            text: item.name,
            id: item.id,
          };
        }),
      };
    },
    cache: false,
  },
});

$("#attendance_method").select2({
  placeholder: "Choose Attendance Method",
  placement: "bottom",
  ajax: {
    url: $("#get_attendance_method_data").val(),
    dataType: "json",
    data: {
      _token: _token,
    },
    type: "POST",
    delay: 250,
    processResults: function (data) {
      return {
        results: $.map(data, function (item) {
          return {
            text: item.name,
            id: item.id,
          };
        }),
      };
    },
    cache: false,
  },
});

// Toast.fire({
//     icon: 'info',
//     type: 'info',
//     title: 'Successfully Updated',
//     timer: 15000000,
// })

breakBack = (ur, next_url) => {
  modalClose();
  $.get(ur, function (data) {
    if (data == "fail") {
      Toast.fire({
        title: $("#something_wrong").val(),
        type: "error",
        icon: "error",
      });
    } else {
      $(".break_back_button").html("");
      $(".break_back_button").html(`<button onclick="breakBack('${next_url}')"
                   class="ml-2 mr-2 btn btn-info box-shadow d-flex align-items-center sm-btn-with-radius">
                   <img class="zoom-in-zoom-out" src="${$("#break_icon").val()}"
                       alt="" style=" width: 19px; height: 19px; padding:0px !important">
               </button>`);
      $(data).appendTo("body");
      $(".modal").modal("show");
    }
  });
};

breakStart = (ur) => {
  modalClose();
  $.get(ur, function (data) {
    if (data == "fail") {
      Toast.fire({
        title: $("#something_wrong").val(),
        type: "error",
        icon: "error",
      });
    } else {
      $(data).appendTo("body");
      $(".modal").modal("show");
    }
  });
};

mainModalOpen = (ur) => {
  // alert(ur);return false;
  modalClose();
  $.ajax({
    url: ur,
    type: "GET",
    success: function (data) {
      if (data == "fail") {
        Toast.fire({
          title: $("#something_wrong").val(),
          type: "error",
          icon: "error",
        });
      } else {
        //modal show using javascript
        $(data).appendTo("body");
        $(".modal").modal("show");
        // $(data).appendTo('body').modal('show');
      }
    },
    error: function (err) {
      if (err?.responseJSON?.message) {
        Toast.fire({
          iconColor: "white",
          icon: "error",
          title: err.responseJSON.message,
        });
      }
    },
  });
};

// $('#__date_range').daterangepicker()

// check in
let check_url;
checkIn = (url) => {
  check_url = url;
  if (navigator?.geolocation) {
    navigator.geolocation.getCurrentPosition(attendanceStore, positionError, {
      timeout: 10000,
    });
  } else {
    console.log("Geolocation is not supported by this browser.");
  }
};

function positionError(error) {
  var errorCode = error.code;
  var message = error.message;
  // toastr.error(message, 'Error!', {
  //     timeOut: 3000
  // });

  attendanceStore();
}

function attendanceStore(position = null) {
  // console.log(position);
  $.ajax({
    type: "GET",
    url: check_url,
    data: {
      latitude: position?.coords?.latitude ?? "23.7909811",
      longitude: position?.coords?.longitude ?? "90.4067015",
    },
    success: function (data) {
      // console.log(data);
      if (data?.result) {
        Toast.fire({
          icon: "success",
          title: data.message,
        });
        setTimeout(function () {
          window.location.href = data?.data;
        }, 3000);
      } else {
        Toast.fire({
          iconColor: "white",
          icon: "error",
          title: "Something went wrong!",
        });
      }
    },
    error: function (data) {
      if (data?.responseJSON?.message) {
        Toast.fire({
          iconColor: "white",
          icon: "error",
          title: data.responseJSON.message,
        });
        // if (data?.responseJSON?.error) {
        //     setTimeout(function () {
        //         window.location.href = data?.responseJSON?.error;
        //     }, 2000)
        // }
      }
    },
  });
}

$(document).ready(function () {
  setTimeout(function () {
    $('[data-toggle="tooltip"]').tooltip("hide", {
      animated: "fade",
      placement: "bottom",
      html: true,
    });
  }, 100);
});

////Get Users
$("#custom_user").select2({
  placeholder: $("#select_custom_members").val(),
  placement: "bottom",
  ajax: {
    url: $("#get_custom_user_url").val(),
    dataType: "json",
    data: {
      _token: _token,
    },
    type: "POST",
    delay: 250,
    processResults: function (data) {
      return {
        results: $.map(data, function (item) {
          return {
            text: item.name,
            id: item.id,
          };
        }),
      };
    },
    cache: true,
  },
});

////Get goals
$("#goal_id").select2({
  placeholder: $("#select_goals").val(),
  placement: "bottom",
  ajax: {
    url: url + "/admin/performance/goal/get-goal",
    dataType: "json",
    type: "POST",
    delay: 250,
    processResults: function (data) {
      return {
        results: $.map(data, function (item) {
          return {
            text: item.name,
            id: item.id,
          };
        }),
      };
    },
    cache: true,
  },
});

var __date_range = {};

$(function () {
  $("#daterange").daterangepicker(
    {
      showDropdowns: false,
      applyButtonClasses: "apply-btn",
      cancelButtonClasses: "cancel-btn",
      locale: {
        cancelLabel: "Cancel",
        applyLabel: "Set Data",
        format: "YYYY-MM-DD",
      },

      ranges: {
        Today: [moment(), moment()],
        Yesterday: [moment().subtract(1, "days"), moment().subtract(1, "days")],
        "Last 7 Days": [moment().subtract(6, "days"), moment()],
        "Last 30 Days": [moment().subtract(29, "days"), moment()],
        "This Month": [moment().startOf("month"), moment().endOf("month")],
        "Last Month": [
          moment().subtract(1, "month").startOf("month"),
          moment().subtract(1, "month").endOf("month"),
        ],
      },
      showCustomRangeLabel: true,
      alwaysShowCalendars: true,
      startDate: moment(),
      endDate: moment(),
      drops: "auto",
    },
    function (start, end) {
      __date_range = {
        from: start.format("YYYY-MM-DD"),
        to: end.format("YYYY-MM-DD"),
      };
      if ($("#daterange-input").length > 0) {
        $("#daterange-input").change();
      }
    }
    
  );

  $('#daterange').on('cancel.daterangepicker', function(ev, picker) {
    picker.setStartDate(moment()); 
    picker.setEndDate(moment()); 
    __date_range = {
      from: '',
      to: '',
    };
    $("#daterange-input").val('');  
    $("#daterange-input").trigger('change'); 
});

  // cb(start, end);
});

//Get Users
$("#members").select2({
  placeholder: $("#select_members").val(),
  placement: "bottom",
  width: "100%",
  ajax: {
    url: $("#get_user_url").val(),
    dataType: "json",
    data: {
      _token: _token,
    },
    type: "POST",
    delay: 250,
    processResults: function (data) {
      return {
        results: $.map(data, function (item) {
          return {
            text: item.name,
            id: item.id,
          };
        }),
      };
    },
    cache: true,
  },
});
$("#_employees").select2({
  placeholder: $("#select_members").val(),
  placement: "bottom",
  width: "100%",
  search: true,
  ajax: {
    url: $("#get_user_url").val(),
    dataType: "json",
    data: function (params) {
      return {
        _token: _token,
        term: params.term,
      };
    },
    type: "POST",
    delay: 250,
    processResults: function (data) {
      return {
        results: $.map(data, function (item) {
          return {
            text: item.name,
            id: item.id,
          };
        }),
      };
    },
    cache: true,
  },
});

$(".s_date").daterangepicker({
  singleDatePicker: true,
  showDropdowns: true,

});
$(".expire-date").daterangepicker({
  singleDatePicker: true,
  showDropdowns: true,
  autoUpdateInput: false,
  locale: {
    cancelLabel: 'Clear'
}

});

$('.expire-date').on('apply.daterangepicker', function(ev, picker) {
  $(this).val(picker.startDate.format('MM/DD/YYYY'));
});



$(function () {
  $(".s_time")
    .daterangepicker({
      timePicker: true,
      singleDatePicker: true,
      timePicker24Hour: $("#time_format").val() == "h" ? false : true,
      timePickerIncrement: 1,
      timePickerSeconds: true,
      locale: {
        format: "HH:mm:ss",
      },
    })
    .on("show.daterangepicker", function (ev, picker) {
      picker.container.find(".calendar-table").hide();
    });
});

const progress = document.querySelector("input[type=range]");


$("#change-user-lang").on("change", function () {
  let selected_lang = $(this).val();
  $.ajax({
    url: $("#change_lang_url").val(),
    type: "POST",
    data: {
      lang: selected_lang,
      _token
    },
    success: function (data) {
      console.log(data.success);
      if (data.success) {
        //page reload
        location.reload();
        toastr.success(data.message, "Success");
      } else {
        toastr.error(data.message, "Error");
      }
    },
  });
});
// $( function() {
//   $( ".datepick" ).datepicker({
//     format: 'yyyy-mm-dd',
//             startDate: '+1d'
//   });
// } );
//check if branch_select exist

if ($(".company-select").length > 0) {
  $select_company = $(".company-select").select2({});
  $select_company.data("select2").$container.addClass("company-select-container");
}


if ($(".branch-select").length > 0) {

  $select_branch = $(".branch-select").select2({});
  $select_branch.data("select2").$container.addClass("language-select-container");
}
$select = $(".language-select").select2({});
$select.data("select2").$container.addClass("language-select-container");

var MenuType = (val) => {
  if (val == 1) {
    $("#menu_page_id").addClass("d-none");
    $("#menu_url_link").removeClass("d-none");
  } else {
    $("#menu_url_link").addClass("d-none");
    $("#menu_page_id").removeClass("d-none");
  }
};
// collapse the menu
// $('.collapse-menu').on('click',function() {
//   $(this).find(".collapse").collapse('toggle');
// });

// $(document).ready(function(){
//   $(".toggle-btn").click(function(){
//     $(this).data('id')
//     $(this).collapse('toggle');
//   });
// });


// File Uploder

  // ONLICK BROUSE FILE UPLOADER 
  var fileInp = document.getElementById("fileBrouse");
  var fileInp2 = document.getElementById("fileBrouse2");
  var fileInp3 = document.getElementById("fileBrouse3");
  var fileInp4 = document.getElementById("fileBrouse4");
  var fileInp5 = document.getElementById("fileBrouse5");
  var fileInp6 = document.getElementById("fileBrouse6");

  if (fileInp) {
    fileInp.addEventListener("change", showFileName);

    function showFileName(event) {
      var fileInp = event.srcElement;
      var fileName = fileInp.files[0].name;
      document.getElementById("placeholder").placeholder = fileName;
    }
  }

  if (fileInp2) {
    fileInp2.addEventListener("change", showFileName);

    function showFileName(event) {
      var fileInp = event.srcElement;
      var fileName = fileInp.files[0].name;
      document.getElementById("placeholder2").placeholder = fileName;
    }
  }
  if (fileInp3) {
    fileInp3.addEventListener("change", showFileName);

    function showFileName(event) {
      var fileInp = event.srcElement;
      var fileName = fileInp.files[0].name;
      document.getElementById("placeholder3").placeholder = fileName;
    }
  }
  if (fileInp4) {
    fileInp4.addEventListener("change", showFileName);

    function showFileName(event) {
      var fileInp = event.srcElement;
      var fileName = fileInp.files[0].name;
      document.getElementById("placeholder4").placeholder = fileName;
    }
  }
  if (fileInp5) {
    fileInp5.addEventListener("change", showFileName);

    function showFileName(event) {
      var fileInp = event.srcElement;
      var fileName = fileInp.files[0].name;
      document.getElementById("placeholder5").placeholder = fileName;
    }
  }
  if (fileInp6) {
    fileInp6.addEventListener("change", showFileName);

    function showFileName(event) {
      var fileInp = event.srcElement;
      var fileName = fileInp.files[0].name;
      document.getElementById("placeholder6").placeholder = fileName;
    }
  }
