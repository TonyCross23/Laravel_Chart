<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/argon-design-system-free@1.2.0/assets/css/argon-design-system.min.css">
    <title>Chart App</title>
</head>

<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-12">
                <div class="card card-body">
                    <form action="" method="POST">
                        @csrf
                        <input type="search" name="about" class="btn btn-secondary btn-sm" placeholder="Enter About">
                        <input type="number" name="amount" class="btn btn-secondary btn-sm" placeholder="Enter Price">
                        <select name="type" class="btn btn-secondary btn-sm">
                            <option value="in">Income</option>
                            <option value="out">Outcome</option>
                        </select>
                        <input type="date" name="date" class="btn btn-secondary btn-sm">
                        <input type="submit" value="Enter" class="btn btn-success btn-sm">
                    </form>
                </div>
            </div>

            <div class="col-6">
                <div class="card mt-4">
                    <ul class="list-group">
                        @foreach ($currency as $c)
                            <li class="list-group-item d-flex justify-content-between">
                                <div class="">
                                    {{ $c->about }} <br>
                                    <small class="text-muted">
                                        {{ $c->date }}
                                    </small>
                                </div>
                                @if ($c->type == 'in')
                                    <div class="text text-success mt-2">+{{ $c->amount }} ks</div>
                                @else
                                    <div class="text text-danger mt-2">-{{ $c->amount }} ks</div>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-6">
                <div class="card card-body mt-4">
                    <div class="d-flex justify-content-between">
                        <p>Today Chart</p>
                        <div class="">
                            <small class="text-success me-2">Income :+{{ $total_income }}ks </small>
                            <small class="text-danger ms-2">Outcome :-{{ $total_outcome }}ks</small>
                        </div>
                    </div>
                    <canvas id="chart"></canvas>
                </div>
            </div>

        </div>

    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    @if (session('success'))
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        Toast.fire({
            icon: 'success',
            title: 'Create successfully'
        })
    @endif

    const ctx = document.getElementById('chart');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($day_arr),
            datasets: [{
                    label: 'Income',
                    data: [12, 19, 3, 5, 2, 3],
                    borderWidth: 1,
                    backgroundColor: '#24a46d',
                },
                {
                    label: 'Outcome',
                    data: [12, 19, 3, 5, 2, 3],
                    borderWidth: 1,
                    backgroundColor: '#f5365c',
                }
            ]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

</html>
