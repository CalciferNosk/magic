$(document).ready(function () {

    $(document).on('submit','#login-form',function(e){
        e.preventDefault();
        var form = $(this).get(0);
        var url = base_url + 'auth/login-exam';
        var formData = new FormData(form);

        formData.append('_cmcToken',  $(`meta[name="_cmcToken"]`).attr("content"));
       
       $.ajax({
           type: "POST",
           url: url,
           data: formData,
           processData: false, // Prevent jQuery from automatically processing the data
           contentType: false, // Set content type to false
           dataType: 'json',
           success: function (result) {
            console.log(result)
               if (result.result == true) {
                   window.location.href = base_url + 'exam-view';
               } else {
                   alert(result.error);
               }
           },
           error: function (xhr, status, error) {
               console.error('Ajax request error:', error);
           }
       });
    })

  $(document).on('submit', '#admin-login-form', function(e) {
      e.preventDefault();
      var form = $(this).get(0);
      var url = base_url + 'auth/admin-login';
      var formData = new FormData(form);
  
      formData.append('_cmcToken', $(`meta[name="_cmcToken"]`).attr("content"));
  
      // Show loading spinner
      showLoading();
  
      $.ajax({
          type: "POST",
          url: url,
          data: formData,
          processData: false,
          contentType: false,
          dataType: 'json',
          success: handleSuccess,
          error: handleError
      });
  
      function handleSuccess(result) {
          hideLoading();
          if (result.result == true) {
            alert('login successful');
              window.location.href = base_url + 'exam-admin-view';
          } else {
              alert(result.mssg);
          }
      }
  
      function handleError(xhr, status, error) {
          hideLoading();
          console.error('Ajax request error:', error);
      }
  
      function showLoading() {
          // Add loading spinner HTML to the page
          // You can use jQuery or plain JavaScript to add the spinner
          // For example:
          // $('body').append('<div class="loading-spinner"></div>');
      }
  
      function hideLoading() {
          // Remove loading spinner HTML from the page
          // You can use jQuery or plain JavaScript to remove the spinner
          // For example:
          // $('.loading-spinner').remove();
      }
  });
})