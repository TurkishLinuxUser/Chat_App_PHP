/*$(document).ready(function() {
    $(".deleteUserBtn").click(function() {
        var id = $(this).data("id");

        $.ajax({
            url: "delete_user.php",
            type: "POST",
            data: { id: id },
            success: function(response) {
                alert(response);
                location.reload();
            },
            error: function(xhr, status, error) {
                console.error(xhr);
                alert("An error occurred while deleting the user.");
            }
        });
    });

    $("#createUserBtn").click(function() {
        $("#createUserPopup").show();
    });

    $(".close").click(function() {
        $("#createUserPopup").hide();
    });

    $("#createUserForm").submit(function(event) {
        event.preventDefault();

        var formData = {
            username: $("#username").val(),
            password: $("#password").val()
        };

        $.ajax({
            url: "create_user.php",
            type: "POST",
            data: formData,
            success: function(response) {
                alert(response);
                location.reload();
            },
            error: function(xhr, status, error) {
                console.error(xhr);
                alert("An error occurred while creating the user.");
            }
        });
    });
});
*/

$(document).ready(function () {

    $(".deleteUserBtn").click(function() {
        var id = $(this).data("id");
        $('#idHidden').val(id);
        $('#deleteUserPopup').fadeIn();
        /*$.ajax({
            url: "delete_user.php",
            type: "POST",
            data: { id: id },
            success: function(response) {
                alert(response);
                location.reload();
            },
            error: function(xhr, status, error) {
                console.error(xhr);
                alert("An error occurred while deleting the user.");
            }
        });*/
    });




    $('#deleteUserPopup #yesdelete').on('click', function(){
        var id = $('#idHidden').val();
        $.ajax({
            url: "delete_user.php",
            type: "POST",
            data: { id: id },
            success: function(response) {
                location.reload();
            },
            error: function(xhr, status, error) {
                console.error(xhr);
                alert("An error occurred while deleting the user.");
            }
        });
    })

    $('#deleteUserPopup #nodelete').on('click', function(){
        $('#deleteUserPopup').hide();
    })

    var popup = $('#createUserPopup');
    var createUserBtn = $('#createUserBtn');
    var closeBtn = $('.close');

    createUserBtn.on('click', function () {
        popup.show();
    });

    closeBtn.on('click', function () {
        popup.hide(200);
    });

    $(window).on('click', function (e) {
        if ($(e.target).is(popup)) {
            popup.hide(200);
        }
    });

    $('#createUserForm').on('submit', function (e) {
        e.preventDefault();
        var username = $('#username').val();
        var password = $('#password').val();

        $.ajax({
            url: 'create_user.php',
            type: 'POST',
            data: {
                username: username,
                password: password
            },
            success: function (response) {
                location.reload();
            },
            error: function (error) {
                alert('Error creating user');
            }
        });
    });

$('.changePasswordBtn').on('click', function() {
    var username = $(this).data('username');
    $('#usernameHidden').val(username);
    $('#changePasswordPopup').fadeIn();
       
    });

$('.close').on('click', function() {
    $('#changePasswordPopup').fadeOut();
});

$('#changePasswordForm').on('submit', function(e) {
    e.preventDefault();
    var username = $('#usernameHidden').val();
    var newPassword = $('#newPassword').val();

    $.ajax({
        url: 'change_password.php',
        type: 'POST',
        data: { 
            newPassword: newPassword,
            username: username
        },
        success: function(response) {
            $('#changePasswordPopup').fadeOut();
            location.reload();
        },
        error: function(error) {
            alert('Error changing password');
        }
    });
});


$('.seeLogBtn').on('click', function () {
        var username = $(this).data('username');
        
        $.ajax({
            url: 'get_logs.php',
            type: 'GET',
            data: { 
                username: username
             },
            success: function (response) {
                if (response.length === 0) {
                    $('#logsContent p').html('No logs found for this user.');
                } else {
                    $('#logsContent p').html(response);
                }
                $('#seeLogsPopup').css('display', 'block');
            },
            error: function (error) {
                alert('Error fetching logs');
            }
        });
});

    $('.close').on('click', function() {
        $(this).closest('.popup').css('display', 'none');
    });

$('#seeLogsPopup .close').on('click', function () {
    $('#seeLogsPopup').fadeOut();
});

$('.closelogspopup').on('click', function (){
    $('#seeLogsPopup').fadeOut();
})
});