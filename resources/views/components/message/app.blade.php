<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doc Aid Diagnostic & Medical Center</title>


    <style>
        :root {
            --base-100: #f1f5f9
        }

        body {
            margin: 0px;
            padding: 0px;
            background-color: var(--base-100);
            font-family: Arial, Helvetica, sans-serif;
        }

        .header {
            width: 100%;
            padding: 2rem;
            display: flex;
            justify-content: center;
        }

        .header-content {
            width: 80%;
            display: flex;
            align-items: center;
            gap: 4rem;
        }

        .header-logo {
            width: 4rem;
            height: 4rem;
            border-radius: 100%;
            object-position: center;
        }

        .header-title p {
            display: flex;
            flex-direction: column;
            text-align: center;
            font-size: smaller;
        }

        /* .content {
            width: 100vw;
            text-align: justify;
            white-space: pre-line;
            padding: 4rem;
        } */

        .main {
            width: 100vw;
            display: flex;
            flex-direction: column;
        }

        .subject-section {
            width: 100%;
            padding: 4px;
            font-weight: bold;
            font-size: small;
        }
    </style>
</head>

<body>
    <div class="main">
        <div class="header">
            <div class="header-content">
                {{-- <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents(public_path('image/logo.png'))) }}"
                    alt="" srcset="" class="header-logo"> --}}
                <div class="header-title">
                    <h1>Doc Aid Diagnostic and Medical Center</h1>
                    {{-- <p>adawda adasda asdsad asd asd asda sada as d</p> --}}
                    <div class="content">
                        @if (isset($subject))
                            <div class="subject-section">
                                <h1 class="subject-content">
                                    <span>Subject : </span> {{ $subject }}
                                </h1>
                            </div>
                        @endif
                        <p>
                            {{ $slot }}
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>

</body>

</html>
