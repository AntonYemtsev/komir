$(document).ready(function(){

  initFileUploader("#zdrop");
    function initFileUploader(target) {
      var previewNode = document.querySelector("#zdrop-template");
      previewNode.id = "";
      var previewTemplate = previewNode.parentNode.innerHTML;
      previewNode.parentNode.removeChild(previewNode);


      var zdrop = new Dropzone(target, {
        url: '/admin/drag-deal-file',
        paramName: "deal_file_src",
        maxFilesize:30,
        previewTemplate: previewTemplate,
        previewsContainer: "#previews",
        clickable: "#upload-label"
      });

      zdrop.on("addedfile", function(file) { 
        // $('.preview-container').css('visibility', 'visible');
      });

      zdrop.on("totaluploadprogress", function (progress) {
        var progr = document.querySelector(".progress .determinate");
          if (progr === undefined || progr === null)
              return;

            progr.style.width = progress + "%";
          });

          zdrop.on('dragenter', function () {
            $('.fileuploader').addClass("active");
          });

          zdrop.on('dragleave', function () {
            $('.fileuploader').removeClass("active");     
          });

          zdrop.on('drop', function () {
            $('.fileuploader').removeClass("active"); 
          });

          zdrop.on('success', function () {
              var args = Array.prototype.slice.call(arguments);

              if(args[1]['success'] == true){
                  alert("Ваш файл успешно загружен");
                  a = $(".clone-deal-other-file-item").clone();
                  a.removeClass("clone-deal-other-file-item");
                  a.addClass("deal-other-file-item");
                  a.css("display","block");
                  a.find("a").attr("href","/deal_files/" + args[1]['deal_file_src']);
                  a.find("#deal-card-7-bill1-name").html(args[1]['deal_file_name']);
                  a.find("#deal-card-7-bill1-date").html(args[1]['deal_file_date']);
                  a.find(".delete-btn").attr("onclick","deleteDealOtherFile(" + args[1]['deal_file_id'] + ", " + args[1]['deal_file_deal_id'] + ",this)");
                  $(".deal-other-files-block").append(a);
              }
              else if(args[1]['success'] == "not_file"){
                  alert("Прикрепите файл");
              }
              else{
                  alert("Ошибка при загрузке файла");
              }

          });
          
      }

  });