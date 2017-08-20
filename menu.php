<html>
	<head>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> </link>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script>
		function submitForm(){
			var data = $("#myForm").serialize();
			//$("#hidden_row_id").val('');
			$.ajax({
				type : "POST",
				url  : "/menu-driven/functionality.php",
				data : data,
				success : function(result){
					console.log(result);
					document.getElementById("closeBtn").click();
					displayAllRecord();
				}
			});
		}
	
	// liSting all the records :
	function displayAllRecord(){
		var str ;
		$.ajax({
			type : "POST",
			url  : '/menu-driven/functionality.php?action=update',
			data : '',
			success : function(result){
				var objData = JSON.parse(result,true);
 				str = "<div id='Main_list'><h3>Listing All Records..</h3><table border='1'><th>User Name</th> <th>Mobile No</th><th>Email</th><th>DOB</th><th>Action</th>";
				for(var i in objData){
					str += "<tr><td>" +objData[i]["userName"] + "</td><td>" +objData[i]["mobileNo"] + "</td><td>" +objData[i]["email"] + "</td><td>" +objData[i]["dob"] + "</td><td><a href='javascript:void(0)' id='updateBtn' onclick='updateRecords("+objData[i]['id']+")'>Update</a>|<a href='javascript:void(0)' id='deleteBtn' onclick='DeleteRecords("+objData[i]["id"]+");'>Delete</a></td></tr>";
				}
				str += "</div></table>";
				$('#listingRecords').html(str);
			}
		});
	}
	
	function DeleteRecords(row_id){
		var result = confirm("Want to delete?");
		if(result){
				$.ajax({
				type : "POST",
				data : 'rowId='+row_id,
				url  : '/menu-driven/functionality.php?action=delete',
				success : function(response){
					console.log(response);
					if(response == '1'){
						displayAllRecord();
					}
				}
			});		
		}else{
			console.log("Cancel Delete records processig!!");
		}
		
	}

	function updateRecords(row_id){
		console.log("Update records processing !!!");	
		$("#hidden_row_id").val(row_id);
		$.ajax({
			type : "POST",
			url  : '/menu-driven/functionality.php?action=rowset',
			data : 'row_id='+row_id,
			success : function(responce){ 
				var objData = JSON.parse(responce,true);
				console.log("Responce");
				console.log(objData);
				console.log(objData['userName']);
				$("#userName").val(objData['userName']);
				$("#mobileNo").val(objData['mobileNo']);
				$("#email").val(objData['email']);
				$("#dob").val(objData['dob']);
			}
		});
		$("#myModal").modal('show');
	}
	</script>
	</head>
	<body>
		<div class="container"><br/>
			<div class="row">
				<div class="col-lg-4"><input type="button" class="btn btn-success" value="Insert" data-toggle="modal" data-target="#myModal"></div>
				<div class="col-lg-4"><input type="button" class="btn btn-success" value="Listing" onclick="displayAllRecord();"></div>			
				</div>
		</div>
	</body>
	
<div id="myModal" class="Modal fade" role="dialog">
	<div class="modal-dialog">

      <div class="modal-content">
        <div class="modal-header">Insert Functionality</div>
    		<div class="modal-body">
    		<form id="myForm">
    			<div class="container">
	    			<div class="row">
	    				<div class="col-lg-3">Name : <input type="text" name="userName" id="userName" ></div>
	    				<div class="col-lg-3">Mobile No : <input type="text" name="mobileNo" id="mobileNo"></div>
	    				
	    			</div>	<br/>
	    			<div class="row">
	    				<div class="col-lg-3">Email : <input type="text" name="email" id="email"></div>
	    				<div class="col-lg-3">DOB : <input type="text" name="dob" id="dob"></div>
	    			</div><br/>
	    			<div class="row">
	    				<div class="col-lg-3">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<input type="button" value="Save" name="btnSave" class="btn btn-success" onclick="return submitForm();">&nbsp;&nbsp;<input type="button" value="Cancel" id="closeBtn" name="btnCancel" class="btn btn-cancel" data-dismiss="modal"></div>
	    			</div>
    			</div>
    		<input type="hidden" value="0" id="hidden_row_id" name="hidden_row_id"/>
    		</form>
			</div>
      </div>
	</div>	
</div> 
 
 
<!--Listing All the  records -->
<div id="listingRecords"></div>

</html>

  