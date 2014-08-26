 <style>
table th{ padding:0 !important;}
.addtask{ border:none !important;}
.addtask tr td{ border:none !important;}
/*.addtask tr td input{ width:100px !important;}*/
</style>
<script type="text/javascript">
 
function updatestatus(id,val){
	//alert('55');
			 	$.get(APP_PATH + "taskpanel/updatetaskstatus" , { id : id ,status:val} , function(data) {
					alert('Updated Successfully');
					window.location.reload();
		 		}, "json");
	}
 
 </script>
<div class="large-6 columns main-content">
        <h1>Task Panel</h1>
        <!--<span style="color:#000; margin:12px; float:right;"><a href="<?php //echo base_url().'taskpanel/addpanel';?>">Add Task</a></span>-->
          <div id="error-login">
          <br />
		<?php if ($this->session->flashdata('result') != ''): 
					echo $this->session->flashdata('result'); 
				endif;
		 ?></div>
        <form action="<?=base_url();?>/taskpanel/addpanel" name="" id="" method="post">
          <table class="addtask">
             
                <tr>
                  <td>   <input type="text" style="" placeholder='Enter Task Name' name="task_name" id="task_name" > </td>
                 <td>   <input type="text" style="width:99px;"  placeholder='Select Date' name="task_date" id="task_date" > </td>
               <!--   <td>  <input type="checkbox" class="checkbox" style="width:100px;"  name="completed" id="completed" value="1"> </td>-->
               
                  <td>  <input class="button" type="submit" value="Add Task" style="margin-top:4px;" name="submit" id="submit"> </td>
              </td>
              </tr>
            
            </table>
            </form> 

        
        <div class="row">
          <table class="task-table">
            <thead>
              <tr>
                <th style="height:39px;" width="200">Task Name</th>
                <th>Due Date</th>
                <th width="150">Completion</th>
                <th width="150">Action</th>
              </tr>
            </thead>
            <tbody>
            <?php $i=0; foreach($alltasks as $task){ ?>
              <tr>
                <td><?=$task['task_name']?></td>
                <td><?=$task['task_date']?></td>
                <td><input type="checkbox" onclick="updatestatus(<?=$task['id']?>,'<?=$task['task_completed']?>')" <?php if($task['task_completed']=='Y'){echo "checked='checked'";}?> class="checkbox" value="<?=@$task['task_completed']?>" id="task_completed"></td>
                <td><a href="javascript:" class="mws-ic-16 ic-cross tableops remove_img_db" style="margin-top:-8px;margin-left: -12px; position: absolute;" onclick="delrec(<?=$task['id']?>)"></a></td>
              </tr>
              <?php 
				  $i++;}
			  ?>
          </tbody></table>
          <script src="<?=base_url();?>js/jquery.js"></script>
<script src="<?=base_url();?>js/jquery.datetimepicker.js"></script>
<script>
	$('#task_date').datetimepicker({
		timepicker:false,
		format:'Y-m-d',
		
	});
	function delrec(id){
		if(confirm('Are You Sure want ro delete this Task?')){
				$.post("<?php echo base_url(); ?>taskpanel/deltask" , { id : id} ,
					function(data){
						alert("Task Deleted!");
						window.location.reload();
				});
			}
		}
</script>
        </div>
      </div>