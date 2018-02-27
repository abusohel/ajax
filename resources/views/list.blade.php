<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Todo for ajax</title>
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
</head>
<body>
	<br>
	<div class="container">
		<div class="row">
			<div class="col-md-offset-3 col-md-6">				
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Ajax Todo List<a href="#" id="addNew" class="pull-right"><i class="fa fa-plus" aria-hidden="true" data-toggle="modal" data-target="#myModal"></i></a></h3>
					</div>
					<div class="panel-body" id="items">
						<ul class="list-group">
							@foreach ($items as $item)
								
						  <li class="list-group-item ourItem" data-toggle="modal" data-target="#myModal">{{$item->item}}
							<input type="hidden" id="itemId" value="{{$item->id}}">
						  </li>
							@endforeach
						</ul>
					</div>
					<div class="panel-heading" id="paginate">{!! $items->links() !!}<div>
				</div>
			</div>
			

			<div class="modal fade" id="myModal" tabindex="-1" role="dialog">
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        <h4 class="modal-title" id="title">Add New Item</h4>
			      </div>
			      <div class="modal-body">
			      	<input type="hidden" id="id">
			        <p><input type="text" placeholder="Write item here" id="addItem" class="form-control"></p>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-warning" id="delete" data-dismiss="modal" style="display: none;">Delete</button>
			        <button type="button" class="btn btn-primary" id="saveChanges" data-dismiss="modal" style="display: none;">Save changes</button>
			        <button type="button" class="btn btn-primary" data-dismiss="modal" id="addButton">Add Item</button>
			      </div>
			    </div><!-- /.modal-content -->
			  </div><!-- /.modal-dialog -->
			</div><!-- /.modal -->

		</div>
	</div>
	{{csrf_field()}}
	<script
			  src="https://code.jquery.com/jquery-3.3.1.min.js"
			  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
			  crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	<script>
		$(document).ready(function() {
			$(document).on('click', '.ourItem', function(event) {
					var text=$(this).text();
					var id=$(this).find('#itemId').val();

					$('#title').text('Edit Item');
					var text=$.trim(text);
					$('#addItem').val(text);
					$('#delete').show('400');
					$('#saveChanges').show('400');
					$('#addButton').hide('400');
					$('#id').val(id);
					console.log(text);
					
			});

			$(document).on('click', '#addNew', function(event) {
					var text=$(this).text();
					$('#title').text('Add New Item');
					$('#addItem').val("");
					$('#delete').hide('400');
					$('#saveChanges').hide('400');
					$('#addButton').show('400');
					console.log(text);
					
			});


			$('#addButton').click(function(event) {
				var text=$('#addItem').val();
				if (text=="") {
					alert("Please type anything");
				}else{
				$.post('list', {'text': text,'_token':$('input[name=_token]').val()}, function(data) {
									console.log(data);
				$('#items').load(location.href + ' #items');
				$('#paginate').load(location.href + ' #paginate');
				});
				}
			});

			$('#delete').click(function(event) {
				var id=$('#id').val();
				$.post('delete', {'id': id,'_token':$('input[name=_token]').val()}, function(data) {
				$('#items').load(location.href + ' #items');
				$('#paginate').load(location.href + ' #paginate');
				console.log(id);
				});
			});

			$('#saveChanges').click(function(event) {
				var id=$('#id').val();
				var value=$('#addItem').val();
				if (value=="") {
					alert("Field not null");
				}else{

				$.post('update', {'id': id, 'value': value,'_token':$('input[name=_token]').val()}, function(data) {
				$('#items').load(location.href + ' #items');
				$('#paginate').load(location.href + ' #paginate');
				console.log(id);
				});
				}
			});
		});
	</script>
</body>
</html>