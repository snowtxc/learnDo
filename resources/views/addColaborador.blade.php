<html>
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- <script
        src="https://kit.fontawesome.com/d2851d0514.js"
        crossorigin="anonymous"
    ></script> -->
    <title>Colaborador</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <style>
        body {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 1200px;
            display: flex;
            background-color: #d0dbdb;
        }

        .container {
            width: 100%;
            height: auto;
        }

        .content {
            display: flex!important;
            position: relative!important;
            margin-bottom: 1rem!important;
            justify-content: center!important;
            align-items: center!important;
            width: 100%!important;
            gap: 0.5rem!important;
            height: 200px!important;
            background: #15d1c1!important;
        }

        .title {
            color: white;
            margin: auto;
            font-weight: 700;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 40px;
        }

        .whiteContent {
            flex-direction: column!important;
            right: 0;
            margin: auto;
            left: 0;
            padding: 1rem;
            background-color: #ffffff;
            justify-content: center!important;
            align-items: center!important;
            height: auto;
            border-radius: 0.375rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1),
                0 2px 4px -1px rgba(0, 0, 0, 0.06);
            top: 80%;
            width: 80%;
        }

        .title2 {
            color: #374151;
            font-family: system-ui, -apple-system, BlinkMacSystemFont,
                "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans",
                sans-serif, "Apple Color Emoji", "Segoe UI Emoji",
                "Segoe UI Symbol", "Noto Color Emoji";
            font-weight: 700;
            color: 30px;
        }

        .image {
            object-fit: cover;
            width: 100%;
            height: auto;
            max-width: 400px;
        }

        .description {
            padding-left: 1rem;
            padding-right: 1rem;
            color: #4b5563;
            font-family: system-ui, -apple-system, BlinkMacSystemFont,
                "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans",
                sans-serif, "Apple Color Emoji", "Segoe UI Emoji",
                "Segoe UI Symbol", "Noto Color Emoji";
            font-weight: 500;
            text-align: center;
            color: 14px;
        }

        .confirmAccountButton {
            text-decoration: none;
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
            padding-left: 1.5rem;
            padding-right: 1.5rem;
            color: #ffffff;
            font-weight: 600;
            border-radius: 0.375rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1),
                0 2px 4px -1px rgba(0, 0, 0, 0.06);
            background: #251945;
            color: 16px;
            margin: auto!important;
        }

        .text1 {
            padding-left: 1rem;
            padding-right: 1rem;
            margin-top: 2rem;
            color: #374151;
            font-family: system-ui, -apple-system, BlinkMacSystemFont,
                "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans",
                sans-serif, "Apple Color Emoji", "Segoe UI Emoji",
                "Segoe UI Symbol", "Noto Color Emoji";
            font-weight: 500;
            text-align: left;
            color: 9px;
        }

        .text2 {
            padding-left: 1rem;
            padding-right: 1rem;
            margin-top: 3rem;
            color: #374151;
            font-family: system-ui, -apple-system, BlinkMacSystemFont,
                "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans",
                sans-serif, "Apple Color Emoji", "Segoe UI Emoji",
                "Segoe UI Symbol", "Noto Color Emoji";
            font-weight: 700;
            text-align: left;
            width: 100%;
            color: 14px;
        }

        @media (min-width: 768px) {
            .title2 {
                color: 50px;
            }

            .content {
                height: 300px;
            }

            .text2 {
                padding-left: 1.5rem;
                padding-right: 1.5rem;
                color: 14px;
            }

            .whiteContent {
                width: 600px;
            }

            .text1 {
                padding-left: 1.5rem;
                padding-right: 1.5rem;
                color: 12px;
            }

            .description {
                padding-left: 1.5rem;
                padding-right: 1.5rem;
            }
        }
    </style>
</head>

<body >
    <div class="container">
        <div class="content">
            <!-- <i
                class="fa-sharp fa-solid fa-graduation-cap text-white text-[40px]"
            ></i> -->
            <p class="title">LearnDo</p>

             <!--  -->
        </div>
        <div class="whiteContent" style="flex-direction: column;justify-content: center!important;align-items:center!important;">
                <h1 class="title2">Nueva colaboracion</h1>

                <img
                    src="https://res.cloudinary.com/dkjujr3gj/image/upload/v1682174823/fpajodz2nhnk7hiwqwh7.png"
                    class="image"
                />
                <h1 class="description">
                    Hola {!! $userMe !!}, {!! $userName !!} te invito a colaborar en el evento {!! $eventoName !!}, accede a la plataforma para poder interacturar
                </h1>
                <div style="width: 100%;display: flex; justify-content:center!important; align-items: center!important;">
                <a href="{!! $link !!}," class="confirmAccountButton">
                    Login
                </a>

                </div>  
                <p class="text1">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit.
                    Cupiditate totam distinctio quis quisquam suscipit
                    quidem, sint repellendus labore veniam neque
                    doloremque,<span
                        class="text-[#15d1c1] cursor-pointer border-b border-b-[#15d1c1]"
                    >
                        temporibus enim quia
                    </span>
                </p>

                <p class="text2">LearnDo Team</p>
            </div>
    </div>
</body>
</html>