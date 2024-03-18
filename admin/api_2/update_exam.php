<?php 
session_start();
include('includes/header.php');

?>
<?php 
  

// Storing session data
   $_SESSION["role"];
   if(!isset($_SESSION["role"]))
   {

    header("location:admin_login.php");
    
    ?>
    <script type="text/javascript">
        window.location.href = "admin_login.php";
    </script>
    <?php
   }
   else
   {
    ?>  
<div class="page-container">    
    <div class="left-content">
        <div class="mother-grid-inner">
            <!--header start here-->
            <div class="header-main" style="min-height: 90px;">
                <div class="header-left">
                    <div class="logo-name">
                        <a href="admin_index.php"> <h3>SICS ADMIN</h3> 
                            </br>
                           
  <h4>Schedule Exam</h4>
                          
                        </a>                              
                    </div>

                    <div class="clearfix"> </div>

                </div>

                <!--notification menu end -->
                <div class="profile_details">       
                    <ul>
                        <li class="dropdown profile_details_drop">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <div class="profile_img">   
                                    <span class="prfil-img"><img src="images/p1.png" alt=""> </span> 
                                    <div class="user-name">
                                        <p>Srishti Innovative</p>
                                        <span><?php echo $_SESSION["name"];?></span>
                                    </div>
                                    <i class="fa fa-angle-down lnr"></i>
                                    <i class="fa fa-angle-up lnr"></i>
                                    <div class="clearfix"></div>    
                                </div>  
                            </a>
                            <ul class="dropdown-menu drp-mnu">
                                    <!-- <li> <a href="#"><i class="fa fa-cog"></i> Settings</a> </li> 
                                    <li> <a href="#"><i class="fa fa-user"></i> Profile</a> </li>  -->
                                <li> <a href="logout.php"><i class="fa fa-sign-out"></i> Logout</a> </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>


                <div class="span5">
		<strong id="msg"> <?php
							if(isset($_REQUEST['status']))
							{
								$msg=$_GET['status'];
							
								if($msg=="success")
								{
									$message = '<div id="alert" class="alert alert-success">Exam Scheduled Successfully.</div>';
								}
								else if($msg=="failed")
								{
									$message = '<div id="alert" class="alert alert-danger"> Exam scheduled Failed.</div>';
								}
								echo $message;
							} ?>
		</strong>
                    <div class="row" style="margin-top:70px;margin-left:50px;">
                        <form class="forms-sample" id="add_assign" action="exam_action.php"  method="post" >
          <p id="demo"></p>
                            <div class="txt-field">
                                 <?php
                                    $query1 = "select * from technologies order by id desc";
                                    $result1 = $con->query($query1);
                                ?>
                                <label>Technology</label><br>
                                <select id="technology" name="technology" required style="width:25%;"> 
                                    <option value="">------------Select------------</option>
                                    <?php
                                        while ($row1 = $result1->fetch_assoc()) {
                                    ?>
                                    <option value="<?php echo $row1["id"]; ?>"><?php echo $row1["name"]; ?></option>
                                    <?php
                                        }
                                    ?>
                                </select>
                            </div> <br>
                            <div class="txt-field">
                                <label>Package</label><br>
                        <select id="semester" placeholder="Package" name="semester"  required="">
                          <option value="">------------Select--------------</option>
                         
                   

                        </select>
                            </div> <br>

 
                            <div class="txt-field">
                                <label>Subject</label><br>
                       <select  id="subject" placeholder="Subject" name="subject">
                          <option value="">---------Select Topic-----------</option>
                     </select> 
                            </div> <br>
                            <div class="txt-field">
                                <label>Exam Date</label><br>
                                <input type="date" id="exam" name="exam"  required  style="width: 280px;"> 
                            </div> <br>
                            <div class="txt-field">
                              
                        <input type="text" name="exam_title" id="exam_title" required="" size="29" placeholder="Exam Title"> 
                            </div> <br>
                            <div class="txt-field">
                                <label >Time Duration (Min)</label><br>
                       <input type="number"  id="examtime" placeholder="Exam Time Duration eg:60" size="29" name="examtime" required=""> 
                            </div> <br>
                             
                             <!--<div class="txt-field">
                                <label >Guest status</label><br>
                       <select id="g_status" name="g_status"><option value="0">------------Select--------------</option>
                        <option value="1">on</option>
                        <option value="0">off</option></select> 
                            </div> <br>
                              <div class="txt-field">
                                <label >Student Status</label><br>
                      <select id="stu_status" name="stu_status"><option value="0">------------Select--------------</option>
                        <option value="1">on</option>
                        <option value="0">off</option></select>
                            </div> <br>-->

                          
                          

                            <input type="submit" class="logins" value="Submit" id="submit">

                        </form>
<br><br><br><br><br>
<br><br><br><br><br>
<br><br><br><br><br>
<br><br><br><br><br>
                    </div>

                </div>
                <div class="clearfix"> </div>               
            </div>
            <div class="clearfix"> </div>   
        </div>

        <!--heder end here-->
        <!-- script-for sticky-nav -->

        <!-- /script-for sticky-nav -->
        <!--inner block start here-->

    </div> 
    <div class="clearfix"> </div>

    <!--slider menu-->
    <?php include('includes/sidebar.php'); ?>

    <div class="clearfix"> </div>
</div>
<!--slide bar menu end here-->

<?php include('includes/footer.php'); ?>
<script type="text/javascript">
        setTimeout(function () {

			// Closing the alert
			$('#alert').alert('close');
		}, 5000); 
         // window.history.replaceState({}, document.title, "/" + "campus2020/admin/schedule_exam.php");
     </script>
<script type="text/javascript">
      $(document).ready(function(){
    $('#technology').on('change', function(){
     // alert('hai');
        var technology = $(this).val();
    
        if(technology){
            $.ajax({
                type:'POST',
                url:'ajaxPackage.php',
                data:'technology='+technology,
                success:function(html){
                    $('#semester').html(html);
                  
                }
            }); 
        }else{
            $('#semester').html('<option value="">Select </option>');
           
        }
    });


      $('#semester').on('change', function(){
     // alert('hai');
        var semester = $(this).val();
       // alert(countryID);
        if(semester){
            $.ajax({
                type:'POST',
                url:'ajaxSyllabus.php',
                data:'semester='+semester,
                success:function(html){
                    $('#subject').html(html);
                  
                }
            }); 
        }else{
            $('#subject').html('<option value="">Select Topic</option>');
           
        }
    });


// $('#submit').click(function(){
//    // alert('hai');
//   var technology= $("#technology").val();
  
//    var semester=$('#semester').val();
//     var subject=$('#subject').val();
//      var exam_title=$('#exam_title').val();
//       var exam=$('#exam').val();
//       var examtime=$('#examtime').val();
//       var g_status=$('#g_status').val();
//       var stu_status=$('#stu_status').val();
//  $.ajax({
//                     type: "POST",  
//                     url: "exam_action.php",
//                     data: "technology=" + technology+"&semester=" + semester+ "&subject=" + subject+ "&exam_title=" + exam_title+ "&exam=" + exam+ "&examtime=" + examtime+"&g_status="+g_status+"&stu_status="+stu_status,
//                     success: function(txt) {
//                         alert(txt);
//                       document.getElementById('demo').innerHTML=txt;
//                     if(txt=='success'){
// $('#success').show();
// $('#semester').val("");
// $('#subject').val("");
// $('#exam_title').val("");
// $('#exam').val("");
// $('#examtime').val("");
//                     }
//                     else if(txt=='exam_exist'){
//                       $('#exist').show();
// $('#semester').val("");
// $('#subject').val("");
// $('#exam_title').val("");
// $('#exam').val("");
// $('#examtime').val("");

//                     }
//                     else{
//                       $('#failed').show();
//                     }
//                     }
//                 });
// });


    
  


     });
    </script>
    <?php
   }
?>  