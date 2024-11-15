
function suggetion() {

    $('#sug_input').keyup(function(e) {

        var formData = {
            'product_name' : $('input[name=title]').val()
        };

        if(formData['product_name'].length >= 1){

          // process the form
          $.ajax({
              type        : 'POST',
              url         : 'ajax.php',
              data        : formData,
              dataType    : 'json',
              encode      : true
          })
              .done(function(data) {
                  //console.log(data);
                  $('#result').html(data).fadeIn();
                  $('#result li').click(function() {

                    $('#sug_input').val($(this).text());
                    $('#result').fadeOut(500);

                  });

                  $("#sug_input").blur(function(){
                    $("#result").fadeOut(500);
                  });

              });

        } else {

          $("#result").hide();

        };

        e.preventDefault();
    });

}
 $('#sug-form').submit(function(e) {
     var formData = {
         'p_name' : $('input[name=title]').val()
     };
       // process the form
       $.ajax({
           type        : 'POST',
           url         : 'ajax.php',
           data        : formData,
           dataType    : 'json',
           encode      : true
       })
           .done(function(data) {
               //console.log(data);
               $('#product_info').html(data).show();
               total();
               $('.datePicker').datepicker('update', new Date());

           }).fail(function() {
               $('#product_info').html(data).show();
           });
     e.preventDefault();
 });
 function total(){
   $('#product_info input').change(function(e)  {
           var price = +$('input[name=price]').val() || 0;
           var qty   = +$('input[name=quantity]').val() || 0;
           var total = qty * price ;
               $('input[name=total]').val(total.toFixed(2));
   });
 }

 $(document).ready(function() {

   //tooltip
   $('[data-toggle="tooltip"]').tooltip();

   $('.submenu-toggle').click(function () {
      $(this).parent().children('ul.submenu').toggle(200);
   });
   //suggetion for finding product names
   suggetion();
   // Callculate total ammont
   total();

   $('.datepicker').datepicker({
    format: 'yyyy-mm-dd',
    todayHighlight: true,
    autoclose: true,
    beforeShowDay: function(date) {
        var today = new Date();

        // Disable dates after today
        return date <= today ? {enabled: true} : {enabled: false};
    }
});
$('.datepicker').attr('readonly', 'readonly');
    $('input[name="start-date"], input[name="end-date"]').change(function() {
        var startDate = new Date($('input[name="start-date"]').val());
        var endDate = new Date($('input[name="end-date"]').val());
        
        // Ensure start date is equal to or earlier than end date
        if (startDate > endDate) {
            alert('error in date selection.');
            $(this).val(''); // Clear the input field
        }
    });
    
});
