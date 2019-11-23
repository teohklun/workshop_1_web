<?php
// view file of report index.php
?>
<h3>Filter information</h3>
<div class='div-form'>
    <button  onclick="location.href='<?= PATH_PUBLIC ?>/report/patient.php'" type="button" class="btn btn-outline-primary width-100 padding-25">
        <span class='button-span'>Patient</span>
    </button>
</div>

<br/>

<h3>Summary report</h3>
<div class='div-form'>

    <div class='form-row'>
    <div class='col-md-2'></div>

        <div class='col-md-4'>
            <button  onclick="location.href='<?= PATH_PUBLIC ?>/report/dateRevenue.php'" type="button" class="btn btn-outline-primary width-100 padding-25">
                <span class='button-span'>Revenue Chart</span>
            </button>
        </div>

        <div class='col-md-4'>
            <button  onclick="location.href='<?= PATH_PUBLIC ?>/report/doctorPerformance.php'" type="button" class="btn btn-outline-primary width-100 padding-25">
            <span class='button-span'>Doctor Revenue</span>
            </button>
        </div>
    <div class='col-md-2'></div>

    </div>
</div>
