<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="http://casaalmada.hostinggratis.it/doc/css/reset.css">
<link rel="stylesheet" href="css/style.css">

<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>importa foglio exel</title>
</head>
<body >

	
    <h1>Importa foglio di calcolo</h1>
	<div class="form">
		<form method="POST" action="index.php" enctype="multipart/form-data">
			
			<div class="dsp form-group">

				<label for="riga">Riga da esportare</label>
				<input type="number" name="riga" id="riga">

				<label>Upload Excel File</label>
				<input type="file" name="file" class="form-control">
			</div>
			<div class="dsp form-group">
				<button type="submit" name="Submit" class="btn btn-success">Upload</button>
			</div>
		
	</form>
	</div>
    
</body>
</html>
