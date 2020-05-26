<!DOCTYPE>
<html>
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
      <title>{{ __("Contact Form") }}</title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  </head>

  <body>
      <h1>Contact from {{ $name }}</h1>
      <ul>
          <li> {{ __("Name") }}: {{$name}} </li>
          <li> {{__("Email")}}: {{$email}} </li>
          <li> {{ __("Subject") }}: {{$subject}} </li>
          <li> {{ __("Message") }}: {{$bodyMessage}} </li>
      </ul>
  </body>
</html>
