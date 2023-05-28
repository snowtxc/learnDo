<!DOCTYPE html>
<html>
<head>
    <title>Certificado de Curso</title>
    

    <style>
        /* Estilos CSS personalizados para el certificado */
          /* Estilos CSS personalizados para el certificado */
          @font-face {
            font-family: 'Roboto';
            src: url('/fonts/Roboto-Black.ttf') format('truetype');
        }

        body {
            font-family: 'Roboto', sans-serif;


        }

        .container {
            width: 600px;
            margin: 0 auto;
            padding: 20px;
            text-align: center;
            border: 20px solid black;
            height: 500px;
            color: white;
            background: #2e1251;
            display: flex;
            flex-direction: column;
            justify-content: center;

        }

        .certificate {
            background-color: #f2f2f2;
            padding: 30px;
            border-radius: 10px;
        }

        .title {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .subtitle {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .name {
            font-size: 32px;
            font-weight: bold;
            margin-bottom: 30px;
        }

        .date {
            font-size: 16px;
            margin-bottom: 50px;
        }

        .signature {
            font-size: 18px;
            font-weight: bold;
        }

      
            .logo {
                color: white;
                font-size: 30px;
            }
            .logo__sub{
               color: #780EFF;
            }
            .marquee {
                color: white;
                font-size: 35px;
                margin: 20px;
            }
            .assignment {
                margin: 20px;
            }
            .person {
                border-bottom: 2px solid white;
                font-size: 32px;
                font-style: italic;
                margin: 20px auto;
                width: 400px;
            }
            .reason {
                margin: 20px;
                margin-top: 30px;
            }

       

        .course_name {
            font-size: 30px;
        }

        .avatar{
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
        }

    </style>
</head>
    <body>
            <div class="container ">
                
                <div class="logo">
                    Learn<span class="logo__sub">Do</span>
                </div>

                <div class="marquee">
                    Certificado de Finalización
                </div>

                <div class="assignment">
                    Este certificado es presentado a:
                </div>

              
                <img src="{{url($user_avatar)}}" class="avatar"/>
                

                <div class="person">
                    {{ $user_nombre}}
                </div>

                <div class="reason">
                    Por haber completado el curso: <br/>
                    <strong class="course_name">{{$curso_nombre}}</strong>
                </div>
            </div>
</body>
</html>