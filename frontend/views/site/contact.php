<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model app\models\ContactForm */

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

    <!-- Start Map -->
    <div id="map" style="width: 100%; height: 300px;">
        <iframe style="width: 100%; height: 300px;" src="https://www.google.com/maps/embed?pb=!1m24!1m12!1m3!1d7763.637327597944!2d103.86588289999997!3d13.361549000000014!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!4m9!3e6!4m3!3m2!1d13.3751611!2d103.90279939999999!4m3!3m2!1d13.453347599999999!2d103.80898049999999!5e0!3m2!1sen!2skh!4v1647057626854!5m2!1sen!2skh" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
    </div>

    <!-- Start Contact -->
    <div class="container py-5">
        <div class="row py-5">
            <form class="col-md-9 m-auto" method="post" role="form">
                <div class="row">
                    <div class="form-group col-md-6 mb-3">
                        <label for="inputname">Name</label>
                        <input type="text" class="form-control mt-1" id="name" name="name" placeholder="Name">
                    </div>
                    <div class="form-group col-md-6 mb-3">
                        <label for="inputemail">Email</label>
                        <input type="email" class="form-control mt-1" id="email" name="email" placeholder="Email">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="inputsubject">Subject</label>
                    <input type="text" class="form-control mt-1" id="subject" name="subject" placeholder="Subject">
                </div>
                <div class="mb-3">
                    <label for="inputmessage">Message</label>
                    <textarea class="form-control mt-1" id="message" name="message" placeholder="Message" rows="8"></textarea>
                </div>
                <div class="row">
                    <div class="col text-end mt-2">
                        <button type="submit" class="btn btn-success btn-lg px-3">Let’s Talk</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- End Contact -->


</div>

<?php

$script = <<< JS
        // var mymap = L.map('mapid').setView([-23.013104, -43.394365, 13], 13);

        // L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
        //     maxZoom: 18,
        //     attribution: 'Zay Telmplte | Template Design by <a href="https://templatemo.com/">Templatemo</a> | Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
        //         '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
        //         'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        //     id: 'mapbox/streets-v11',
        //     tileSize: 512,
        //     zoomOffset: -1
        // }).addTo(mymap);

        // L.marker([-23.013104, -43.394365, 13]).addTo(mymap)
        //     .bindPopup("<b>Zay</b> eCommerce Template<br />Location.").openPopup();

        // mymap.scrollWheelZoom.disable();
        // mymap.touchZoom.disable();
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