<?php

if(session_status() == PHP_SESSION_NONE)
{
    session_start();  
}
else
{

}

if(isset($_SESSION['usuario']))
{


?>
    <footer class="footer">
		<span class="text-right">
		Copyright <a target="_blank" style="color:black">MigZam</a>
		</span>
        
	</footer>

</div>
<!-- END main -->

<script src="../assets/js/modernizr.min.js"></script>
<script src="../assets/js/jquery.min.js"></script>
<script type="text/javascript" src="../assets/plugins/alertifyjs/alertify.js"></script>
<script src="../assets/js/moment.min.js"></script>
<script src="../helpers/funciones.js"></script>    

		
<script src="../assets/js/popper.min.js"></script>
<script src="../assets/js/bootstrap.min.js"></script>

<script src="../assets/js/detect.js"></script>
<script src="../assets/js/fastclick.js"></script>
<script src="../assets/js/jquery.blockUI.js"></script>
<script src="../assets/js/jquery.nicescroll.js"></script>

<!-- App js -->
<script src="../assets/js/pikeadmin.js"></script>

<!-- BEGIN Java Script for this page -->
	<script src="./assets/Chart.min.js"></script>
	<script src="../assets/jquery.dataTables.min.js"></script>
	<script src="../assets/dataTables.bootstrap4.min.js"></script>
	<script type="text/javascript" src="../assets/dataTables.responsive.min.js"></script>

	<!-- Counter-Up-->
	<script src="../assets/plugins/waypoints/lib/jquery.waypoints.min.js"></script>
	<script src="../assets/plugins/counterup/jquery.counterup.min.js"></script>			



</body>
</html>
<!-- BEGIN Java Script for this page -->
<script src="../assets/plugins/select2/js/select2.min.js"></script>

<?php
}
else {
    header("location:../index.php");    
}
?>
