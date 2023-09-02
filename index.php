<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <title></title>
</head>
<body>
    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-lg-12">
                <form method="POST" id="urlForm">
                    <div class="form-group">
                        <label>URL</label>
                        <input type="text" name="url" id="url" class="form-control" required />
                    </div>
                    <button class="btn btn-primary btn-md" id="submitBtn">Query</button>
                </form>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-lg-6">
                <label>URL Response</label>
                <textarea id="urlResponse" class="form-control" rows="20"></textarea>
            </div>
            <div class="col-lg-6">
                <label>Processed URL Response</label>
                <textarea id="processedUrlResponse" class="form-control" rows="20"></textarea>
            </div>
        </div>
    </div>
    <!-- Optional JavaScript; choose one of the two! -->
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready( () =>{

            $("#url").val(localStorage.getItem('url'));

            $("#url").keyup( () => {
                localStorage.setItem('url',$("#url").val()); 
            });


            $("#urlForm").submit( (e) => {
                e.preventDefault();

                $.ajax({
                    url     : 'action.php?action=getUrlResponse',
                    method  :   'POST',
                    dataType:   'JSON',
                    data    :   {url:$("#url").val()},
                    success: function (data) {
                        $("#urlResponse").html(data.response);
                        $("#processedUrlResponse").html(data.processedResponse);
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        var message = errorThrown;
                        if (jqXHR.responseText !== null && jqXHR.responseText !== 'undefined' && jqXHR.responseText !== '') {
                            message = jqXHR.responseText;
                        }
                        console.log(message);
                    }
                });
            });

        });
    </script>

</body>
</html>