<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="">
        <div>Phone numbers</div>
        <div class="flex  grid-col gap-8">
            <div class="">
                <select name="country" id="">
                    <option>Select country</option>
                    @foreach ($countries as $country)
                        <option value="{{$country['name']}}" {{ request()->country == $country['name']  ? 'selected' : ''  }}> {{$country['name']}} </option>
                    @endforeach
                </select>
            </div>

            <div class="">
                <select name="valid" id="" >
                    <option>Valid phone numbers</option>
                    <option value=true {{ request()->valid == 'true'  ? 'selected' : ''  }}>Valid</option>
                    <option value=false {{ request()->valid == 'false'  ? 'selected' : ''  }}>Not valid</option>
                </select>
            </div>
        </div>

        <div class="m-16">
            <table class="w-full text-center">
                <thead>
                    <th>Country</th> 
                    <th>State</th>
                    <th>Country code</th>
                    <th>Phone num</th>
                </thead>
                <tbody>
                    @foreach ($customers as $customer)
                        <tr>
                            <td>{{ $customer->country->name }}</td>
                            <td>{{ $customer->state }}</td>
                            <td>{{ $customer->country->code }}</td>
                            <td>{{ $customer->phone }}</td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{$customers->links()}}
        </div>
    </body>
    <script>
        // Function to handle select change
        function handleSelectChange() {
            let selects = document.querySelectorAll('select');
            let urlParams = new URLSearchParams(window.location.search);
    
            selects.forEach(select => {
                select.addEventListener('change', function() {
                    if (this.selectedIndex === 0) {
                        urlParams.delete(this.name);
                    } else {
                        // Set or update the URL parameter
                        urlParams.set(this.name, this.value);
                    }
                    
                    // Reload the page with the new query parameters
                    window.location.search = urlParams.toString();
                });
            });
        }
    
        // Initialize the function on window load
        window.onload = handleSelectChange;
    </script>
    
</html>
