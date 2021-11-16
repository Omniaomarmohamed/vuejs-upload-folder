<!DOCTYPE html>
<html>
 <head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>How to upload file using Vue.js with PHP</title>
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
  <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
  
 </head>
 <body class="text-capitalize ">
  <div class="container" id="uploadApp">
   <br />
   <h1 class="text-success" > upload images </h1>
   <br />
   <div v-if="successAlert" class="alert alert-success alert-dismissible">
    <a href="#" class="close" aria-label="close" @click="successAlert=false">&times;</a>
    {{ successMessage }}
   </div>

   <div v-if="errorAlert" class="alert alert-danger alert-dismissible">
    <a href="#" class="close" aria-label="close" @click="errorAlert=false">&times;</a>
    {{ errorMessage }}
   </div>
   <div class="panel panel-default">
    <div class="panel-heading">
     <div class="row">
      <div class="col-md-6">
       <h3 class="ml-auto">Upload File</h3>
      </div>
      <div class="col-md-6">
       
      </div>
     </div>
    </div>
    <div class="panel-body">
     <div class="row">
      <div class="col-md-4" >
       <label class="lead">Select Image</label>
      </div>
      <div class="col-md-4">
       <input class="form-control" type="file" ref="file" />
      </div>
      <div class="col-md-4">
       <button class="btn btn-success mr-auto" type="button" @click="uploadImage" >Upload Image</button>
      </div>
     </div>
     <br />
     <br />
     <div v-html="uploadedImage"></div>
    </div>
   </div>
  </div>
 </body>

</html>

<!-- js -->
<script>

var application = new Vue({
 el:'#uploadApp',
 data:{
  file:'',
  successAlert:false,
  errorAlert:false,
  uploadedImage:'',
 },
 methods:{
  uploadImage:function(){

   application.file = application.$refs.file.files[0];

   var formData = new FormData();

   formData.append('file', application.file);

   axios.post('upload.php', formData, {
    header:{
     'Content-Type' : 'multipart/form-data'
    }
   }).then(function(response){
    if(response.data.image == '')
    {
     application.errorAlert = true;
     application.successAlert = false;
     application.errorMessage = response.data.message;
     application.successMessage = '';
     application.uploadedImage = '';
    }
    else
    {
    // alert(response.data);
     application.errorAlert = false;
     application.successAlert = true;
     application.errorMessage = '';
     application.successMessage = response.data.message;
     var image_html = "<img src='"+response.data.image+"' class='img-thumbnail' width='400' />";
     application.uploadedImage = image_html;
     application.$refs.file.value = '';
    }
   });
  }
 },
});
</script>
