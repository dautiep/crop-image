<html>  
    <head>  
        <title>Make Price Range Slider using JQuery with PHP Ajax</title>  
  
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        <meta name="csrf-token" content="{{ csrf_token() }}">

    </head>  
    <body>  
        <div class="container">
          <br />
      <h3 align="center">Image Crop & Upload using JQuery with PHP Ajax</h3>
      <br />
      <br />
    <div class="panel panel-default">
      <div class="panel-heading">Select Profile Image</div>
      <div class="panel-body" align="center">
       <input type="file" name="upload_image" id="upload_image" accept="image/*" />
       <br />
       <div id="uploaded_image"></div>
      </div>
     </div>
    </div>
    </body>  
</html>

<div id="uploadimageModal" class="modal" role="dialog">
 <div class="modal-dialog">
  <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Upload & Crop Image</h4>
        </div>
        <div class="modal-body">
          <div class="row">
       <div class="col-md-8 text-center">
        <div id="image_demo" style="width:350px; margin-top:30px"></div>
       </div>
       <div class="col-md-4" style="padding-top:30px;">
        <br />
        <br />
        <br/>
        <button class="btn btn-success crop_image">Crop & Upload Image</button>
     </div>
    </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
     </div>
    </div>
</div>

<script>  
$(document).ready(function(){
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    }); 

 $image_crop = $('#image_demo').croppie({
    enableExif: true,
    viewport: {
      width:200,
      height:200,
      type:'square' //circle
    },
    boundary:{
      width:300,
      height:300
    }
  });

  $('#upload_image').on('change', function(){
    var reader = new FileReader();
    reader.onload = function (event) {
      $image_crop.croppie('bind', {
        url: event.target.result
      }).then(function(){
        console.log('jQuery bind complete');
      });
    }
    reader.readAsDataURL(this.files[0]);
    $('#uploadimageModal').modal('show');
  });

  $('.crop_image').click(function(event){
    $image_crop.croppie('result', {
      type: 'canvas',
      size: 'viewport'
    }).then(function(response){
      $.ajax({
        url:"{{route('cropie')}}",
        type: "POST",
        contentType: 'multipart/form-data',
        data:{"upload_image": response},
        dataType:'JSON',
        success:function(data)
        {
          $('#uploadimageModal').modal('hide');
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(thrownError);
        }
        
      });
    })
  });

});  
</script>
</html>