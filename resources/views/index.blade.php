<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Laravel</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">  
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.js"></script>

  </head>
  <body>
    <div class="container">
      @if (\Session::has('success'))
      <div class="alert alert-success">
        <p>{{ \Session::get('success') }}</p>
      </div><br />
     @endif
        <div class="row">
          <div class="col-md-4"></div>
          <div class="form-group col-md-4">
            <label for="Search">Search:</label>
            <input type="text" class="form-control" id="search" name="search" autocomplete="off">
          </div>
        </div>
    </div>
    <script type="text/javascript">
        var path = "{{ url('search') }}";
        var typeAheadStrings = [];

        // @Input array
        // @return array without duplicates
        function stelUnique(array){
          return $.grep(array,function(el,index){
            return index == $.inArray(el,array);
          });
        }

        $('#search-foton').typeahead({
            minLength: 2,
            source:  function (query, process) {
              return $.get(path, { query: query }, function (data) {

                    for (var i = 0; i < data.length; i++) {
                      if (data[i].tags) {
                        data[i] = data[i].tags;
                        
                        // Remove the commas
                        while(data[i].indexOf(",") > -1){ 
                          data[i] = data[i].replace(",", "");
                        }

                        // Remove the dots
                        while(data[i].indexOf(".") > -1){ 
                          data[i] = data[i].replace(".", "");
                        }

                        // Split the string into words
                        dataParts = data[i].split(" ");
                        
                        // Add the words to array, in lowercase
                        for (var j = 0; j < dataParts.length; j++) {
                          typeAheadStrings.push(mb_convert_case(dataParts[j], MB_CASE_LOWER, "UTF-8") );
                        }
                      }
                    }

                    typeAheadStrings.sort();
                    typeAheadStrings = stelUnique( typeAheadStrings );

                    //This is only for logging
                    //console.log(typeAheadStrings.length +  " typeAheadStrings after: " + JSON.stringify(typeAheadStrings, null, 2) ); // spacing level = 2 ///////////////////////////////

                    //return process(typeAheadStrings);
                    return process("björkö");

              });
            }
        });

    </script>
  </body>
</html>