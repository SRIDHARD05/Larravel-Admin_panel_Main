import $ from 'jquery';
window.$ = window.jQuery = $;

import axios from 'axios';

import './dashboard';


function toggleVisibility() {
    if ($('input[name="checkbox"]:checked').length > 0) {
        $('#employee-export-btn').css('display', 'block');
    } else {
        $('#employee-export-btn').css('display', 'none');
    }
}

$(document).ready(function () {

    // $("#logout-all-devices-btn").on('click', function () {
    //     Swal.fire({
    //         title: "Logout All Devices!",
    //         input: "password",
    //         inputLabel: "Enter your password",
    //         showCancelButton: true,
    //         confirmButtonText: 'Submit',
    //         cancelButtonText: 'Cancel',
    //         inputValidator: (value) => {
    //             if (!value) {
    //                 return "You need to write something!";
    //             }
    //         }
    //     }).then(({ value: password, isConfirmed }) => {
    //         if (isConfirmed && password) {
    //             $.ajax({
    //                 url: "/logout/all_devices",
    //                 type: 'POST',
    //                 data: {
    //                     _token: $('meta[name="csrf-token"]').attr('content'),
    //                     password: password
    //                 },
    //                 success: function (response) {
    //                     console.log('Logout from all devices successful', response);
    //                     Swal.fire('You have logged out from all devices.');
    //                 },
    //                 error: function (xhr, status, error) {
    //                     console.error('Error during logout from all devices');
    //                     alert('Error occurred during logout.');
    //                 }
    //             });
    //         } else if (!isConfirmed) {

    //         } else {
    //             Swal.fire("No password was entered.");
    //         }
    //     });
    // });


    $("#checkbox-all-section").on('change', function () {
        var isChecked = this.checked;
        $("input[type='checkbox'][name='checkbox']").prop('checked', isChecked);
        toggleVisibility();
    });

    $(document).on('change', 'input[name="checkbox"]', function () {
        toggleVisibility();
    });

    $("#employee-export-btn").on('click', function () {
        var selectedIds = [];

        $("input[name='checkbox']:checked").each(function () {
            var checkboxId = $(this).attr('id');
            selectedIds.push(checkboxId);
        });

        axios.post('/search/download_file',
            {
                selectedIds: selectedIds,
                type: "type"
            },
            {
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // CSRF token
                }
            }
        )
            .then(response => {
                console.log('Success:', response.data);
            })
            .catch(error => {
                console.error('Error:', error.response ? error.response.data : error.message);
            });



        // var data = @json($data);

        // for (var i = 0; i < data.data.length; i++) {
        //     if (data.data[i].id == checkboxId) {

        //         employeeData = data.data[i];

        //         delete employeeData.id;
        //         employeeData.id = selectedEmployees.length + 1;
        //         selectedEmployees.push(employeeData);
        //     }
        // }

    });

    // var json = JSON.stringify(selectedEmployees, null, 2);
    // var blob = new Blob([json], {
    //     type: "application/json"
    // });

    // var a = document.createElement("a");
    // a.href = URL.createObjectURL(blob);
    // a.download = "selected_employees.json";
    // a.click();

    // $.ajax({
    //     url: `{{ route('search.file_download_notify') }}`,
    //     type: 'GET',
    //     success: function (response) {
    //         console.log('Download completed');
    //     },
    //     error: function (xhr, status, error) {
    //         console.error("An error occurred: " + error);

    //     }
    // });
});


$(document).ready(function () {
    var path = window.location.pathname;

    $('.nav-link').each(function () {
        var linkPath = $(this).attr('href');
        if (linkPath === path) {
            $(this)
                .addClass('active bg-gradient-dark text-white')
                .removeClass('text-dark');
        } else {
            $(this)
                .removeClass('active bg-gradient-dark text-white')
                .addClass('text-dark');
        }
    });
});
