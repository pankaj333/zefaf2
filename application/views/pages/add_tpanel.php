<style>
/* table th{ padding:0 !important;} */
</style>

<div class="large-6 columns main-content">
        <h1>Add Task</h1>
         <div id="error-login">
		<?php if ($this->session->flashdata('result') != ''): 
					echo $this->session->flashdata('result'); 
				endif;
		 ?></div>
        <div class="row">
        <form action="" name="" id="" method="post">
          <table class="task-table">
            <thead>
                <tr>
                    <th>Task Name</th>
                    <td><input type="text" name="task_name" id="task_name" ></td>
                </tr>
                <tr>
                    <th>Due Date</th>
                    <td><input type="text" name="task_date" id="task_date" ></td>
                </tr>
                <tr>
                    <th>Completion</th>
                    <td><input type="checkbox" class="checkbox" name="completed" id="completed" value="1"></td>
              </tr>
               <tr>
                    <th colspan="2">
                    <input type="submit" value="Submit" name="submit" id="submit" class="button"></td>
              </tr>
            </thead>
            </table>
            </form> 
<script src="<?=base_url();?>js/jquery.js"></script>
<script src="<?=base_url();?>js/jquery.datetimepicker.js"></script>
<script>
	$('#task_date').datetimepicker({
		timepicker:false,
		format:'Y-m-d',
		
	});
</script>
        </div>
      </div>
	 