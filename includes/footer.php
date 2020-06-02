
					</div>
				</div>


				<!-- jQuery Version 1.11.1 -->
				<script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>

				<!-- Bootstrap Core JavaScript -->
				<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

				<script type="text/javascript" src="//cdn.ckeditor.com/4.4.3/standard/ckeditor.js"></script>
				<script type="text/javascript" src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
				<script type="text/javascript" src="//cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>

				<script type="text/javascript">
					 $(document).ready(function () {

					 	$("#sidebarCollapse, #sidebarExtend").on("click", function () {
							$("#sidebar").toggleClass("active");
						});

						$("#sorted").DataTable( {
							"bStateSave": true,
							"sPaginationType": "full_numbers"
						});
					 });
				</script>

				<script type="text/javascript">
				function navConfirm(loc) {
					if (confirm("Are you sure?")) {
						window.location.href = loc;
					}
					return false;
				}
				</script>

				
			</body>
			</html>