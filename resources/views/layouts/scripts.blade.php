

<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
<script src="https://unpkg.com/filepond/dist/filepond.js"></script>
<script src="https://unpkg.com/filepond-plugin-file-poster/dist/filepond-plugin-file-poster.js"></script>



<!-- Apex Chart -->
<script src="{{ asset('vendor/apexchart/apexchart.js') }}"></script>



<!-- Chart piety plugin files -->
<!-- Dashboard 1 -->

<script src="{{ asset('vendor/owl-carousel/owl.carousel.js') }}"></script>
<script src="{{ asset('vendor/chart.js/Chart.bundle.min.js') }}"></script>
<script src="{{ asset('vendor/lightgallery/js/lightgallery-all.min.js') }}"></script>

<script src="{{ asset('vendor/global/global.min.js') }}"></script>
<script src="{{ asset('vendor/jquery-nice-select/js/jquery.nice-select.min.js') }}"></script>
<script src="{{ asset('js/custom.min.js') }}"></script>
<script src="{{ asset('js/dlabnav-init.js') }}"></script>
<script src="{{ asset('js/demo.js') }}"></script>
<script src="{{ asset('js/styleSwitcher.js') }}"></script>
<script src="{{ asset('vendor/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('js/plugins-init/select2-init.js') }}"></script>
<script src="{{ asset('vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/plugins-init/datatables.init.js') }}"></script>
<script src="{{ asset('vendor/jquery-steps/build/jquery.steps.min.js') }}"></script>
<script src="{{ asset('vendor/jquery-validation/jquery.validate.min.js') }}"></script>
<!-- Form validate init -->
<script src="{{ asset('js/plugins-init/jquery.validate-init.js') }}"></script>
<script src="{{ asset('vendor/peity/jquery.peity.min.js') }}"></script>

<!-- Form Steps -->
<script src="{{ asset('vendor/jquery-smartwizard/dist/js/jquery.smartWizard.js') }}"></script>
<script src="{{ asset('vendor/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>

<script>

// FilePond
FilePond.registerPlugin(FilePondPluginImagePreview);
const inputElement = document.querySelector('#filepond');
const pond = FilePond.create(inputElement, {
    storeAsFile: true,
});

    $(document).ready(function() {

        $('#smartwizard').smartWizard();

        $("#smartwizard").on("leaveStep", function(e, anchorObject, stepNumber, stepDirection) {

            if (stepDirection === 1) {

                $('.sw-btn-next, .sw-btn-prev').hide();
            } else {

                $('.sw-btn-next, .sw-btn-prev').show();
            }
            if (stepDirection === 2) {

            $('.sw-btn-next, .sw-btn-prev').hide();
            } else {

            $('.sw-btn-next, .sw-btn-prev').show();
            }
        });
    });
</script>

<script>
    function cardsCenter()
    {
        
        /*  testimonial one function by = owl.carousel.js */
        

        
        jQuery('.card-slider').owlCarousel({
            loop:true,
            margin:0,
            nav:true,
            //center:true,
            slideSpeed: 3000,
            paginationSpeed: 3000,
            dots: true,
            navText: ['<i class="fas fa-arrow-left"></i>', '<i class="fas fa-arrow-right"></i>'],
            responsive:{
                0:{
                    items:1
                },
                576:{
                    items:1
                },	
                800:{
                    items:1
                },			
                991:{
                    items:1
                },
                1200:{
                    items:1
                },
                1600:{
                    items:1
                }
            }
        })
    }
    
    jQuery(window).on('load',function(){
        setTimeout(function(){
            cardsCenter();
        }, 1000); 
    });
    
</script>

<script>
    $(document).ready(function() {

        $('#smartwizard1').smartWizard();

        $("#smartwizard1").on("leaveStep", function(e, anchorObject, stepNumber, stepDirection) {

            if (stepDirection === 1) {

                $('.sw-btn-next, .sw-btn-prev').hide();
            } else {

                $('.sw-btn-next, .sw-btn-prev').show();
            }
          
        });
    });
</script>
<script>
    $(document).ready(function() {

        $('#smartwizard2').smartWizard();

        $("#smartwizard2").on("leaveStep", function(e, anchorObject, stepNumber, stepDirection) {

            if (stepDirection === 1) {

                $('.sw-btn-next, .sw-btn-prev').hide();
            } else {

                $('.sw-btn-next, .sw-btn-prev').show();
            }
            if (stepDirection === 2) {

            $('.sw-btn-next, .sw-btn-prev').hide();
            } else {

            $('.sw-btn-next, .sw-btn-prev').show();
            }
            if (stepDirection === 3) {

            $('.sw-btn-next, .sw-btn-prev').hide();
            } else {

            $('.sw-btn-next, .sw-btn-prev').show();
            }
          
        });
    });
</script>

<script>
    function showInputs() {
        var selectedType = $("#salaryType").val();
        var inputContainer = $("#inputContainer");

        inputContainer.empty();

        if (selectedType !== '') {
            if (selectedType === 'fixed') {
                inputContainer.append('<label for="fixedSalary">Enter Fixed Salary:</label>');
                inputContainer.append('<input class="form-control" type="text" id="fixedSalary" name="fixedSalary">');
            } else if (selectedType === 'hourly') {
                inputContainer.append('<label for="hourlyRate">Enter Hourly Rate:</label>');
                inputContainer.append('<input class="form-control" type="text" id="hourlyRate" name="hourlyRate">');
            } else if (selectedType === 'commission') {
                inputContainer.append('<label for="commissionRate">Enter Commission Rate:</label>');
                inputContainer.append('<input class="form-control" type="text" id="commissionRate" name="commissionRate">');
            } else if (selectedType === 'performance') {
                inputContainer.append('<label for="performanceBonus">{{ucFirst(__('models/offre.max_salaire'))}}</label>');
                inputContainer.append('<input class="form-control" type="text" id="performanceBonus" name="max_salaire">');
                inputContainer.append('<label for="performanceBonus">{{ucFirst(__('models/offre.min_salaire'))}}</label>');
                inputContainer.append('<input class="form-control" type="text" id="performanceBonus" name="min_salaire">');
            }

            // Display the container
            inputContainer.show();
        } else {
            // Hide the container if no option is selected
            inputContainer.hide();
        }
    }
</script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelector('.logout-button').addEventListener('click', function(event) {
            event.preventDefault();
            document.getElementById('logout-form').submit();
        });
    });
</script>

