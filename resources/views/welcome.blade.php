<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Readability</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<style>
.flex-wrapper {
   display: flex;
   flex-flow: row nowrap;
}

.single-chart {
   width: 33%;
   justify-content: space-around;
}

.circular-chart {
   display: block;
   margin: 10px auto;
   max-width: 80%;
   max-height: 200px;
}

.circle-bg {
   fill: none;
   stroke: #eee;
   stroke-width: 3.8;
}

.circle {
   fill: none;
   stroke-width: 2.8;
   stroke-linecap: round;
   animation: progress 1s ease-out forwards;
}

@keyframes progress {
   0% {
      stroke-dasharray: 0 100;
   }
}

.circular-chart.orange .circle {
   stroke: #ff9f00;
}

.circular-chart.green .circle {
   stroke: #4CC790;
}

.circular-chart.blue .circle {
   stroke: #3c9ee5;
}

.circular-chart.red .circle {
   stroke: #DA3636;
}

.percentage {
   fill: #666;
   font-family: sans-serif;
   font-size: 0.5em;
   text-anchor: middle;
}
</style>

<body>
   <div class="container">
      <nav class="navbar navbar-light bg-light">
         <span class="navbar-brand mb-0 h1">Readability Score</span>
      </nav>
      <br>
      <br>
      <form action="{{route('read')}}" method="POST">
         @csrf
         <input name="inputUrl" class="form-control">
         <br>
         <button type="submit" class="btn btn-danger">Submit</button>
      </form>
      @if (\Session::has('success'))
      <div class="alert alert-success">
         <ul>
            <li>{!! \Session::get('success') !!}</li>
         </ul>
      </div>
      @elseif(\Session::has('danger'))
      <div class="alert alert-danger">
         <ul>
            <li>{!! \Session::get('danger') !!}</li>
         </ul>
      </div>
      @endif
      <br>
      <br>
      @if(isset($titleOfThePage))
      <p>The title of the page is: <b class="text-success">{{$titleOfThePage}}</b></p>
      <p>Excerpt of the page is:
         <b>{{ $excerpt}}</b>
      </p>
      <p>Number of words: <b>{{$wordsCount}}</b></p>
      <p>Based on your content of the url, Your Readabilty Score is <b class="text-success"> {{$readabiltyScore}} %</b>
      </p>
      <div class="container ml-5">
         @if($readabiltyScore >= 90)
         <div class="single-chart">
            <svg viewBox="0 0 36 36" class="circular-chart green">
               <path class="circle-bg" d="M18 2.0845
          a 15.9155 15.9155 0 0 1 0 31.831
          a 15.9155 15.9155 0 0 1 0 -31.831" />
               <path class="circle" stroke-dasharray="{{$readabiltyScore}}, 100" d="M18 2.0845
          a 15.9155 15.9155 0 0 1 0 31.831
          a 15.9155 15.9155 0 0 1 0 -31.831" />
               <text x="18" y="20.35" class="percentage">{{$readabiltyScore}}</text>
            </svg>
         </div>
         <h4 class="text-success">Excellent</h4>

         @elseif($readabiltyScore >= 75)
         <div class="single-chart">
            <svg viewBox="0 0 36 36" class="circular-chart orange">
               <path class="circle-bg" d="M18 2.0845
          a 15.9155 15.9155 0 0 1 0 31.831
          a 15.9155 15.9155 0 0 1 0 -31.831" />
               <path class="circle" stroke-dasharray="{{$readabiltyScore}}, 100" d="M18 2.0845
          a 15.9155 15.9155 0 0 1 0 31.831
          a 15.9155 15.9155 0 0 1 0 -31.831" />
               <text x="18" y="20.35" class="percentage">{{$readabiltyScore}}</text>
            </svg>
         </div>
         <h4 class="text-info">Very Good</h4>

         @elseif($readabiltyScore >= 50)
         <div class="single-chart">
            <svg viewBox="0 0 36 36" class="circular-chart blue">
               <path class="circle-bg" d="M18 2.0845
          a 15.9155 15.9155 0 0 1 0 31.831
          a 15.9155 15.9155 0 0 1 0 -31.831" />
               <path class="circle" stroke-dasharray="{{$readabiltyScore}}, 100" d="M18 2.0845
          a 15.9155 15.9155 0 0 1 0 31.831
          a 15.9155 15.9155 0 0 1 0 -31.831" />
               <text x="18" y="20.35" class="percentage">{{$readabiltyScore}}</text>
            </svg>
         </div>
         <h4 class="text-primary">Good</h4>

         @elseif($readabiltyScore < 25) <div class="single-chart">
            <svg viewBox="0 0 36 36" class="circular-chart red">
               <path class="circle-bg" d="M18 2.0845
          a 15.9155 15.9155 0 0 1 0 31.831
          a 15.9155 15.9155 0 0 1 0 -31.831" />
               <path class="circle" stroke-dasharray="{{$readabiltyScore}}, 100" d="M18 2.0845
          a 15.9155 15.9155 0 0 1 0 31.831
          a 15.9155 15.9155 0 0 1 0 -31.831" />
               <text x="18" y="20.35" class="percentage">{{$readabiltyScore}}</text>
            </svg>
      </div>
      <h4 class="text-danger">Poor</h4>

      @endif
   </div>
   @else
   <br>
   <br>
   <p>Please provide a url to check the readabilty score of the page</p>
   @endif

   </div>
   <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"
      integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous">
   </script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
      integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous">
   </script>
</body>

</html>