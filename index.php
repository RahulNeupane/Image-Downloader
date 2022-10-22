<?php
    if(isset($_POST['downloadBtn'])){
        $imgURL = $_POST['file'];
        $regPattern = '/\.(jpe?g|png|gif|bmp|webp)$/i';
        if(preg_match($regPattern,$imgURL)){
            $initCURL = curl_init($imgURL);
            curl_setopt($initCURL,CURLOPT_RETURNTRANSFER,true);
            $downloadImgLink = curl_exec($initCURL);
            curl_close($initCURL);
            //now we converet base 64 format to jpg to download
            header('Content-type: image/img'); //in which extensioini to save img
            header('Content-Disposition: attachment;filename="image.jpg"');
            echo $downloadImgLink;
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Downloader</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
</head>
<body>
    <div class="wrapper">
        <div class="preview-box">
            <div class="cancel-icon"><i class="fas fa-times"></i></div>
            <div class="img-preview"></div>
            <div class="content">
                <div class="img-icon"><i class="far fa-image"></i></div>
            </div>
            <div class="text">Paste the image url below,<br>to see a preview or download !</div>
        </div>
        <form action="index.php" method='POST' class="input-data">
            <input type="text" name='file' placeholder="paste the image url to download" id="field">
            <input type="submit" name='downloadBtn' id="button" value="Download">
        </form>
    </div>
</body>

<script>
    $(document).ready(function(){
        //if user focus out input field
        $('#field').on('focusout',function(){
            //getting user entered url
            var imgURL = $('#field').val();
            if(imgURL !== ''){
                //pattern to validate image extension
                var regPattern = /\.(jpe?g|png|gif|bmp|webp)$/i;
                if(regPattern.test(imgURL)){
                    var imgTag = '<img src="'+ imgURL +'" alt="">'
                    $('.img-preview').append(imgTag);
                    $('#button').addClass('active');
                    $('#field').addClass('disabled')
                    $('.preview-box').addClass('imgActive')
                    $('.cancel-icon').on('click',function(){
                        $('#button').removeClass('active');
                        $('#field').removeClass('disabled')
                        $('.preview-box').removeClass('imgActive')
                        $('.img-preview img').remove();
                    });
                }else{
                    alert('Invalid img URL - ' + imgURL);
                    $('#field').val('');
                }
            }
        })
    })
</script>
</html>