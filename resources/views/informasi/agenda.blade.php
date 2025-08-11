<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda Kegiatan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @vite('resources/css/app.css')

    <style>
    .highlight-date {
        background-color: #ffc107;
        color: #fff;
        border-radius: 50%;
        display: inline-block;
        width: 35px;
        height: 35px;
        line-height: 35px;
        text-align: center;
        font-weight: 600;
    }
</style>
</head>

<body class="bg-light">
    <x-navbar />

    <header class="position-relative" style="height: 250px; background: url('https://images.unsplash.com/photo-1519751138087-5bf79df62d5b?q=80&w=2070&auto=format&fit=crop') center center / cover no-repeat;">
        <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark" style="opacity: 0.7;"></div>
        <div class="position-absolute top-50 start-50 translate-middle text-white text-center">
            <h1 style="font-size: 40px;" class="fw-bold">Agenda Kegiatan</h1>
        </div>
    </header>

    <main class="container my-5">

        <div class="text-center mb-4">
            <h3 class="fw-bold">Juli 2025</h3>
        </div>

        <!-- Calendar -->
        <div class="table-responsive">
            <table class="table text-center align-middle" style="border-collapse: separate; border-spacing: 10px;">
                <thead class="table-light">
                    <tr>
                        <th>Mon</th>
                        <th>Tue</th>
                        <th>Wed</th>
                        <th>Thu</th>
                        <th>Fri</th>
                        <th>Sat</th>
                        <th>Sun</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td></td>
                        <td>1</td>
                        <td>2</td>
                        <td>3</td>
                        <td><span class="highlight-date">4</span></td>
                        <td>5</td>
                        <td>6</td>
                    </tr>
                    <tr>
                        <td>7</td>
                        <td>8</td>
                        <td>9</td>
                        <td>10</td>
                        <td><span class="highlight-date">11</span></td>
                        <td>12</td>
                        <td>13</td>
                    </tr>
                    <tr>
                        <td>14</td>
                        <td>15</td>
                        <td>16</td>
                        <td>17</td>
                        <td>18</td>
                        <td><span class="highlight-date">19</span></td>
                        <td>20</td>
                    </tr>
                    <tr>
                        <td>21</td>
                        <td><span class="highlight-date">22</span></td>
                        <td>23</td>
                        <td>24</td>
                        <td>25</td>
                        <td>26</td>
                        <td>27</td>
                    </tr>
                    <tr>
                        <td>28</td>
                        <td><span class="highlight-date">29</span></td>
                        <td>30</td>
                        <td>31</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Events -->
        <div class="mt-5">
            @php
                $events = [
                    ['date' => '04 Juli', 'title' => 'Peresmian Bandung Sadayana'],
                    ['date' => '11 Juli', 'title' => 'Acara Komunitas Digital'],
                    ['date' => '19 Juli', 'title' => 'Workshop Smart City'],
                    ['date' => '22 Juli', 'title' => 'Diskusi Teknologi Informasi'],
                    ['date' => '29 Juli', 'title' => 'Rapat Koordinasi Diskominfo']
                ];
            @endphp

            @foreach ($events as $event)
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center bg-white p-4 mb-3 rounded-4 shadow-sm border border-1">
                <div class="text-center text-md-start mb-2 mb-md-0">
                    <h5 class="fw-bold mb-1 text-primary">{{ $event['date'] }}</h5>
                    <span class="text-dark">{{ $event['title'] }}</span>
                </div>
                <a href="#" class="btn btn-outline-primary px-4">Lihat Detail</a>
            </div>
            @endforeach
        </div>
    </main>


    <x-footer />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
