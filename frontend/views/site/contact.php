<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\helpers\Url;

$this->title = 'Contact';
// $this->params['breadcrumbs'][] = $this->title;
// 
?>
<div class="site-contact">
    <!-- Start Content Page -->
    <div class="container-fluid bg-light py-5">
        <div class="col-md-6 m-auto text-center">
            <h1 class="h1">Contact Us</h1>
            <p>
                Proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                Lorem ipsum dolor sit amet.
            </p>
        </div>
    </div>

    <div id="dvMap" style="height:100%"></div>
    <!-- Replace the value of the key parameter with your own API key. -->
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAl-vYuMnRu_XczpCpg4lZCgKRsUT5-5BM&callback=initMap">
    </script>

    <!-- Start Contact -->
    <div class="container">
        <div class="row justify-content-center">
            <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>
            <div class="input-group">
                <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'email') ?>
            </div>
            <?= $form->field($model, 'subject') ?>

            <?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>

            <div class="form-group">
                <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
    <!-- End Contact -->


</div>

<?php

$script = <<< JS
                var markers = [{
            "timestamp": 'Alibaug',
            "latitude": '18.641400',
            "longitude": '72.872200',
            "description": 'Alibaug is a coastal town and a municipal council in Raigad District in the Konkan region of Maharashtra, India.'
        },
        {
            "timestamp": 'Mumbai',
            "latitude": '18.964700',
            "longitude": '72.825800',
            "description": 'Mumbai formerly Bombay, is the capital city of the Indian state of Maharashtra.'
        },
        {
            "timestamp": 'Pune',
            "latitude": '18.523600',
            "longitude": '73.847800',
            "description": 'Pune is the seventh largest metropolis in India, the second largest in the state of Maharashtra after Mumbai.'
        },
        {
            "timestamp": 'Bhopal',
            "latitude": '23.2599',
            "longitude": '73.857800',
            "description": 'Pune is the seventh largest metropolis in India, the second largest in the state of Maharashtra after Mumbai.'
        },
        {
            "timestamp": 'Bhopal',
            "latitude": '26.9124',
            "longitude": '75.7873',
            "description": 'Pune is the seventh largest metropolis in India, the second largest in the state of Maharashtra after Mumbai.'
        }
        ];
        window.onload = function() {
        var mapOptions = {
            center: new google.maps.LatLng(markers[0].latitude, markers[0].longitude),
            zoom: 10,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        var map = new google.maps.Map(document.getElementById("dvMap"), mapOptions);
        var infoWindow = new google.maps.InfoWindow();
        var lat_lng = new Array();
        var latlngbounds = new google.maps.LatLngBounds();
        for (i = 0; i < markers.length; i++) {
            var data = markers[i]
            var myLatlng = new google.maps.LatLng(data.latitude, data.longitude);
            lat_lng.push(myLatlng);
            var marker = new google.maps.Marker({
            position: myLatlng,
            map: map,
            title: data.timestamp
            });
            // console.log(i)

            latlngbounds.extend(marker.position);
            (function(marker, data) {
            google.maps.event.addListener(marker, "click", function(e) {
                infoWindow.setContent(data.timestamp);
                infoWindow.open(map, marker);
            });
            })(marker, data);
        }
        map.setCenter(latlngbounds.getCenter());
        map.fitBounds(latlngbounds);

        //***********ROUTING****************//


        //Initialize the Direction Service
        var service = new google.maps.DirectionsService();




        //Loop and Draw Path Route between the Points on MAP
        for (var i = 0; i < lat_lng.length; i++) {
            if ((i + 1) < lat_lng.length) {
            var src = lat_lng[i];
            var des = lat_lng[i + 1];
            // path.push(src);

            service.route({
                origin: src,
                destination: des,
                travelMode: google.maps.DirectionsTravelMode.WALKING
            }, function(result, status) {
                if (status == google.maps.DirectionsStatus.OK) {

                //Initialize the Path Array
                var path = new google.maps.MVCArray();
                //Set the Path Stroke Color
                var poly = new google.maps.Polyline({
                    map: map,
                    strokeColor: '#4986E7'
                });
                poly.setPath(path);
                for (var i = 0, len = result.routes[0].overview_path.length; i < len; i++) {
                    path.push(result.routes[0].overview_path[i]);
                }
                }
            });
            }
        }
        }

          $(document).on("click",".trigggerModal",function(){
                  $("#modal").modal("show").find("#modalContent").load($(this).attr("value"));
                  });
                  let map;

            // function initMap() {
            // map = new google.maps.Map(document.getElementById("map"), {
            //     center: { lat: -34.397, lng: 150.644 },
            //     zoom: 8,
            // });
            // }
        

JS;
$this->registerJs($script);


?>