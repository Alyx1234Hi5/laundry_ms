
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
        integrity="sha384-hrmPO4HCmSpvwyuLWHX5z5xXkz8TjJU5pXcFpFQwqfOeG8Bl/5+PtcO87NNb5O4" crossorigin="anonymous">
    <link href='https://unpkg.com/@fullcalendar/core@5.10.1/main.min.css' rel='stylesheet' />
    <link rel="stylesheet" href="dashboard.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
   <link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
      integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"/>

  <!--link for graph-->
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name = "viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">

</head>

<body>
    <div class="progress"></div>
    <div class="sidebar">
        <div class="top">
            <div class="logo">
                <img src="/system/images/laundry_logo.png" alt="Laundry logo">
                <span>Azia Skye's Laundry</span>
            </div>
            <i class='bx bx-menu' id="btnMenu"></i>
        </div>

        <div class="user">
            <img src="/system/images/laundry_logo.png" alt="Profile" class="user-image">
            <div>
                <!-- <p class="bold">
                    <?php echo $_SESSION['username']; ?>
                </p>
                <p>
                    <?php echo ucfirst($_SESSION['user_role']) ?>
                </p> -->
            </div>
        </div>

        <ul>
            <li>
                <a href="/system/dashboard/dashboard.html">
                    <i class="bx bxs-grid-alt"></i>
                    <span class="nav-item">Dashboard</span>
                </a>
                <span class="tooltip">Dashboard</span>
            </li>

            <li>
                <a href="/system/my profile/profile.html">
                    <i class='bx bxs-user'></i>
                    <span class="nav-item">Profile</span>
                </a>
                <span class="tooltip">Profile</span>
            </li>

            <li>
                <a href="/system/users/users.html">
                    <i class='bx bxs-group'></i>
                    <span class="nav-item">Users</span>
                </a>
                <span class="tooltip">Users</span>
            </li>

            <li>
                <a href="/system/records/records.html">
                    <i class='bx bxs-folder-open'></i>
                    <span class="nav-item">Records</span>
                </a>
                <span class="tooltip">Records</span>
            </li>

            <li>
                <a href="/system/transaction/transaction.html">
                    <i class='bx bx-transfer-alt'></i>
                    <span class="nav-item">Transaction</span>
                </a>
                <span class="tooltip">Transaction</span>
            </li>

            <li>
                <a href="/system/sales report/report.html">
                    <i class='bx bx-line-chart'></i>
                    <span class="nav-item">Report</span>
                </a>
                <span class="tooltip">Report</span>
            </li>

            <li>
                <a href="/system/settings/settings.html">
                    <i class='bx bxs-cog'></i>
                    <span class="nav-item">Settings</span>
                </a>
                <span class="tooltip">Settings</span>
            </li>

            <!--<?php if ($_SESSION['user_role'] == 'admin'): ?> -->
            <li>
                <a href="/system/archive/archive.html">
                    <i class='bx bxs-archive-in'></i>
                    <span class="nav-item">Archived</span>
                </a>
                <span class="tooltip">Archived</span>
            </li>
            <!-- <?php endif; ?> -->

            <li>
                <a href="logout.php">
                    <i class='bx bx-log-out'></i>
                    <span class="nav-item">Logout</span>
                </a>
                <span class="tooltip">Logout</span>
            </li>
        </ul>
    </div>

    <div class="main-content">
        <div class="cards-container">
            <h1>Dashboard</h1>
            <div class="cards">
                <div class="card">
                    <h3>Pick-up request</h3>
                    <p id="pickup_orders"><?= $pickuporders_count ?></p>       
                </div>
                <div class="card">
                    <h3>Delivery request</h3>
                    <p id="delivery_orders"><?= $deliveryorders_count ?></p>
                </div>
                <div class="card">
                    <h3>Rush request</h3>
                    <p id="rush_orders"><?= $rushorders_count ?></p>
                </div>
            </div>
            <?php
                // Connect to database
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "laundry_db";

                $conn = new mysqli($servername, $username, $password, $dbname);

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
  
                $query = "SELECT laundry_service_option, COUNT(laundry_service_option) as total FROM service_request GROUP BY laundry_service_option";
                $result = $conn->query($query);
                
                // Create arrays to store data
                $laundry_category_options = array();

                $pickuporders_count = 0;
                $deliveryorderscount = 0;
                $rushorderscount = 0;

                while ($row = $result->fetch_assoc()) {
                    if ($row['laundry_service_option'] == 'Pick up') {
                        $pickuporders_count = $row['total'];
                    } elseif ($row['laundry_service_option'] == 'Delivery') {
                        $deliveryorderscount = $row['total'];
                    } elseif ($row['laundry_service_option'] == 'Rush') {
                        $rushorderscount = $row['total'];
                    }
                }

                // Close connection
                $conn->close();
                
                ?>
                <script>
                const options = [
                { option: 'Pick up', count: <?= $pickuporders_count?> },
                { option: 'Delivery', count: <?= $deliveryorderscount ?> },
                { option: 'Rush', count: <?= $rushorderscount ?> }
                ];

                // Get the HTML elements
                const pickup_orders = document.getElementById('pickup_orders');
                const delivery_orders = document.getElementById('delivery_orders');
                const rush_orders = document.getElementById('rush_orders');

                options.forEach((option) => {
                switch (option.option) {
                    case 'Pick up':
                        pickup_orders.textContent = option.count;
                    break;
                    case 'Delivery':
                        delivery_orders.textContent = option.count;
                    break;
                    case 'Rush':
                        rush_orders.textContent = option.count;
                    break;
                }
                });
              </script>
        </div>
<!---------------------------------- ORDERS CHART ----------------------------------->
<!--------------------------------- DAY GRAPH-CHART --------------------------------->       
         
        <div class = "charts">
            <div class="chart">
                <h3>Orders In Day<button id="Btn" data-modal="dayModal" >
                <i class='bx bx-menu'></i></button></h3>
                <canvas id="daychart" width="230" height="235"></canvas>
               
               <?php    
                // Connect to database
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "laundry_db";

                $conn = new mysqli($servername, $username, $password, $dbname);

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
  
                $query = "SELECT laundry_category_option, SUM(price) as price FROM service_request WHERE DATE(request_datetime) = CURDATE() GROUP BY laundry_category_option";
                $result = $conn->query($query);
                
                // Create arrays to store data
                $laundry_category_options = array();
                $prices = array();
                
                // Fetch data from query
                while ($row = $result->fetch_assoc()) {
                  $laundry_category_options[] = $row['laundry_category_option'];
                  $prices[] = $row['price'];
                }
                
                // Close connection
                $conn->close();
                ?>
                    <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        const ctx = document.getElementById('daychart').getContext('2d');
                        const daychart = new Chart(ctx, {
                            type: 'doughnut',
                            data: {
                                labels: <?php echo json_encode($laundry_category_options); ?>,
                                datasets: [{
                                    label: 'Category',
                                    data: <?php echo json_encode($prices); ?>,
                                    backgroundColor: [
                                        'rgba(255, 99, 132, 1)',
                                        'rgba(54, 162, 235, 1)',
                                        'rgba(255, 206, 86, 1)',
                                    ],
                                    borderColor: [
                                        'rgba(255, 99, 132, 1)',
                                        'rgba(54, 162, 235, 1)',
                                        'rgba(255, 206, 86, 1)',
                                    ],
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        });
                    });

                    var modals = document.querySelectorAll('.modal');
                    var btns = document.querySelectorAll('button');

    
                     btns.forEach(function(btn) {
                     btn.onclick = function() {
                     var modalId = btn.getAttribute('data-modal');
                     var modal = document.getElementById(modalId);
                     modal.style.display = "block";
                    }
                    });

                    var closeBtns = document.querySelectorAll('.close');

                    // Add event listeners to close buttons
                    closeBtns.forEach(function(closeBtn) {
                    closeBtn.onclick = function() {
                        var modal = closeBtn.parentNode.parentNode;
                        modal.style.display = "none";
                    }
                    });

                    // Add event listener to window
                    window.onclick = function(event) {
                    modals.forEach(function(modal) {
                        if (event.target == modal) {
                        modal.style.display = "none";
                        }
                    });
                     }

                    // Close all modals 
                    window.onload = function() {
                    modals.forEach(function(modal) {
                        modal.style.display = "none";
                    });
                    }
            </script>   

                    <div id="dayModal" class="modal">
                      <div class="day-content">
                      <span class="close">&times;</span>
                       <canvas id="daychartModal"></canvas>
                    </div>
                     </div>

            <script>
                    document.addEventListener("DOMContentLoaded", function() {
                            const ctx = document.getElementById('daychartModal').getContext('2d');
                                const daychart = new Chart(ctx, {
                                    type: 'doughnut',
                                       data: {
                                            labels: <?php echo json_encode($laundry_category_options); ?>,
                                               datasets: [{
                                                 label: 'Category',
                                                    data: <?php echo json_encode($prices); ?>,
                                                        backgroundColor: [
                                                            'rgba(255, 99, 132, 1)',
                                                            'rgba(54, 162, 235, 1)',
                                                            'rgba(255, 206, 86, 1)',
                                                        ],
                                                        borderColor: [
                                                            'rgba(255, 99, 132, 1)',
                                                            'rgba(54, 162, 235, 1)',
                                                            'rgba(255, 206, 86, 1)',
                                                        ],
                                                        borderWidth: 1
                                                    }]
                                                },
                                                options: {
                                                    scales: {
                                                        y: {
                                                            beginAtZero: true
                                                }
                                           }
                                      }
                                });
                             }); 
                    </script>
                  </div><!---CHART END--->

  <!---------------------------------  ORDERS PER WEEK  ----------------------------------->
            <div class="chart">
            <h3>Orders In Week<button id="Btn1" data-modal="weekModal" >
            <i class='bx bx-menu'></i></button></h3>
                <canvas id="weekchart" width="230" height="200"></canvas>
               
                <?php
                    // Connect to database
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "laundry_db";

                    $conn = new mysqli($servername, $username, $password, $dbname);

                    // Check connection
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    $query = "SELECT 
                                laundry_category_option, 
                                SUM(price) as price 
                            FROM 
                                service_request 
                            WHERE 
                                YEARWEEK(request_datetime) = YEARWEEK(CURDATE()) 
                                AND laundry_category_option IN ('Dry', 'Wash', 'Fold')
                            GROUP BY 
                                laundry_category_option 
                            ORDER BY 
                                price DESC";
                    $result = $conn->query($query);

                    // Create arrays to store data
                    $laundry_category_options = array();
                    $prices = array(); 

                    while ($row = $result->fetch_assoc()) {
                        $laundry_category_options[] = $row['laundry_category_option'];
                        $prices[] = $row['price'];
                    }

                    // Close connection
                    $conn->close();
                    ?>

            <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        const ctx = document.getElementById('weekchart').getContext('2d');
                        const weekchart = new Chart(ctx, {
                            type: 'pie',
                            data: {
                                labels: <?php echo json_encode($laundry_category_options); ?>,
                                datasets: [{
                                    label: 'Category',
                                    data: <?php echo json_encode($prices); ?>,
                                    backgroundColor: [
                                        'rgba(255, 99, 132, 1)',
                                        'rgba(54, 162, 235, 1)',
                                        'rgba(255, 206, 86, 1)',
                                    ],
                                    borderColor: [
                                        'rgba(255, 99, 132, 1)',
                                        'rgba(54, 162, 235, 1)',
                                        'rgba(255, 206, 86, 1)',
                                    ],
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        });
                    }); 

                    var modals = document.querySelectorAll('.modal');
                    var btns = document.querySelectorAll('button');

                    btns.forEach(function(btn) {
                    btn.onclick = function() {
                        var modalId = btn.getAttribute('data-modal');
                        var modal = document.getElementById(modalId);
                        modal.style.display = "block";
                    }
                    });

                    var closeBtns = document.querySelectorAll('.close');
                    closeBtns.forEach(function(closeBtn) {
                    closeBtn.onclick = function() {
                        var modal = closeBtn.parentNode.parentNode;
                        modal.style.display = "none";
                    }
                    });

                    // Add event listener to window
                    window.onclick = function(event) {
                    modals.forEach(function(modal) {
                        if (event.target == modal) {
                        modal.style.display = "none";
                        }
                    });
                    }

                    // Close all modals on page reload
                    window.onload = function() {
                    modals.forEach(function(modal) {
                        modal.style.display = "none";
                    });
                    }
                        </script>
            </div><!--chartend-->


     <!--------------------- ORDERS A MONTH ------------------------->              

            <div class="chart">
            <h3>Orders In Month<button id="Btn2" data-modal="monthModal" >
            <i class='bx bx-menu'></i></button></h3>
                <canvas id="monthchart" width="230" height="240"></canvas>
                
                <?php
                    // Connect to database
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "laundry_db";

                    $conn = new mysqli($servername, $username, $password, $dbname);

                    // Check connection
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }
                    $query = "SELECT 
                    laundry_category_option, 
                    MONTH(request_datetime) as month, 
                    SUM(price) as total_price 
                    FROM service_request 
                    WHERE YEAR(request_datetime) = YEAR(CURDATE()) 
                    GROUP BY  laundry_category_option, 
                    MONTH(request_datetime) ORDER BY month";
       
                    $result = $conn->query($query);
                    
                    // Create arrays to store data
                    $data = array();
                    
                    while ($row = $result->fetch_assoc()) {
                        if (!isset($data[$row['laundry_category_option']])) {
                            $data[$row['laundry_category_option']] = array();
                        }
                        $data[$row['laundry_category_option']][] = array(
                            'month' => $row['month'],
                            'total_price' => $row['total_price']
                        );
                    }
       
                    // Close connection
                    $conn->close();
                    ?>
       
                 <script>
                        document.addEventListener("DOMContentLoaded", function() {
                        const ctx = document.getElementById('monthchart').getContext('2d');
                        const chartData = {
                            labels: [],
                            datasets: []
                        };

                        const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

                        const colors = {
                        'Wash': {
                            backgroundColor: 'rgba(54, 162, 235, 1)',
                            borderColor: 'rgba(54, 162, 235, 1)'
                        },
                        'Dry': {
                            backgroundColor: 'rgba(255, 206, 86, 1)',
                            borderColor: 'rgba(255, 206, 86, 1)'
                        },
                        'Fold': {
                            backgroundColor: 'rgba(255, 99, 132, 1)',
                            borderColor: 'rgba(255, 99, 132, 1)'
                        }
                    };

                <?php foreach ($data as $category => $values) { ?>
                    chartData.datasets.push({
                        label: '<?php echo $category; ?>',
                        data: [],
                        backgroundColor: colors['<?php echo $category; ?>'].backgroundColor,
                        borderColor: colors['<?php echo $category; ?>'].borderColor,
                        borderWidth: 1
                    });

                <?php foreach ($values as $value) { ?>
                    chartData.labels.push(monthNames[<?php echo $value['month'] - 1; ?>]);
                    chartData.datasets[chartData.datasets.length - 1].data.push('<?php echo $value['total_price']; ?>');
                <?php } ?>
                <?php } ?>

         // Remove duplicates from labels array
                chartData.labels = [...new Set(chartData.labels)];

                    const daychart = new Chart(ctx, {
                        type: 'bar',
                        data: chartData,
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                });
            </script>    
       </div>


        <!-------------------------- ORDERS A YEAR ----------------->
            <div class="chart">
            <h3>Orders In Year<button id="Btn3" data-modal="yearModal" >
            <i class='bx bx-menu'></i></button></h3>
                <canvas id="yearchart" width="350" height="235"></canvas>
                    
            <?php
// Connect to database
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "laundry_db";

                $conn = new mysqli($servername, $username, $password, $dbname);

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $query = "SELECT 
                            YEAR(request_datetime) as year, 
                            laundry_category_option, 
                            SUM(price) as price 
                        FROM 
                            service_request 
                        GROUP BY 
                            YEAR(request_datetime), 
                            laundry_category_option 
                        ORDER BY 
                            year";
                $result = $conn->query($query);

                // Create arrays to store data
                $labels = array();
                $category_data = array();

                // Fetch data from query
                while ($row = $result->fetch_assoc()) {
                    $labels[] = $row['year'];
                    $category_data[$row['laundry_category_option']][$row['year']] = $row['price'];
                }

                // Close connection
                $conn->close();

                // Remove duplicates from labels array
                $labels = array_unique($labels);
                sort($labels);

                // Create datasets
                $datasets = array();
                foreach ($category_data as $category => $data) {
                    $dataset = array();
                    foreach ($labels as $label) {
                        if (isset($data[$label])) {
                            $dataset[] = $data[$label];
                        } else {
                            $dataset[] = null;
                        }
                    }
                    $color = '';
                    switch ($category) {
                        case 'Dry':
                            $color = 'rgba(255, 206, 86, 1)'; // blue
                            break;
                         case 'Wash':
                            $color = 'rgba(54, 162, 235, 1)'; // yellow
                            break;    
                        case 'Fold':
                            $color = 'rgba(255, 99, 132, 1)'; // pink
                            break;
                       
                    }
                    $datasets[] = array(
                        'label' => $category,
                        'data' => $dataset,
                        'backgroundColor' => $color,
                        'borderColor' => $color,
                        'borderWidth' => 1
                    );
                }
                ?>

            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    const ctx = document.getElementById('yearchart').getContext('2d');
                    const yearchart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: <?php echo json_encode($labels); ?>,
                            datasets: <?php echo json_encode($datasets); ?>
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                });</script>
             </div>  
            </div><!--end of charts-->   
  

     <!-------------------------------------- MODAL --------------------------------------------->

            <div id="weekModal" class="modal">
                <div class="week-content">
                <span class="close">&times;</span>
                <canvas id="weekchartModal"></canvas>
                </div>
            </div>

            <script>
                // Get all modals
                var modals = document.querySelectorAll('.modal');

                // Get all buttons that open the modals
                var btns = document.querySelectorAll('button');

                // Add event listeners to buttons
                btns.forEach(function(btn) {
                btn.onclick = function() {
                    var modalId = btn.getAttribute('data-modal');
                    var modal = document.getElementById(modalId);
                    modal.style.display = "block";
                }
                });

                            // Get all close buttons
                var closeBtns = document.querySelectorAll('.close');

                // Add event listeners to close buttons
                closeBtns.forEach(function(closeBtn) {
                closeBtn.onclick = function() {
                    var modal = closeBtn.parentNode.parentNode;
                    modal.style.display = "none";
                }
                });

                // Add event listener to window
                window.onclick = function(event) {
                modals.forEach(function(modal) {
                    if (event.target == modal) {
                    modal.style.display = "none";
                    }
                });
                }

                // Close all modals on page reload
                window.onload = function() {
                modals.forEach(function(modal) {
                    modal.style.display = "none";
                });
                }

                const canvas = document.getElementById("weekchartModal");
                canvas.width = 40;
                canvas.height = 30;
                            
            document.addEventListener("DOMContentLoaded", function() {
            const ctx = document.getElementById('weekchartModal').getContext('2d');
            const weekchart = new Chart(ctx, {
                type: 'pie',
                                    data: {
                                        labels: <?php echo json_encode($laundry_category_options); ?>,
                                        datasets: [{
                                            label: 'Category',
                                            data: <?php echo json_encode($prices); ?>,
                                            backgroundColor: [
                                                'rgba(255, 99, 132, 1)',
                                                'rgba(54, 162, 235, 1)',
                                                'rgba(255, 206, 86, 1)',
                                            ],
                                            borderColor: [
                                                'rgba(255, 99, 132, 1)',
                                                'rgba(54, 162, 235, 1)',
                                                'rgba(255, 206, 86, 1)',
                                            ],
                                            borderWidth: 1
                                        }]
                                    },
                                    options: {
                                        scales: {
                                            y: {
                                                beginAtZero: true
                                            }
                                        }
                                    }
                                });
                            }); 
                 </script>
            </div>

    
       <!----------------------------- CALENDAR -------------------------------->
       <div class="container">
            <div class="left">
                <div class="calendar">
                <div class="month">
                    <i class="fas fa-angle-left prev"></i>
                    <div class="date">December 2015</div>
                    <i class="fas fa-angle-right next"></i>
                </div>
                <div class="weekdays">
                    <div>Sun</div>
                    <div>Mon</div>
                    <div>Tue</div>
                    <div>Wed</div>
                    <div>Thu</div>
                    <div>Fri</div>
                    <div>Sat</div>
                </div>
                <div class="days"></div>
                </div>
            </div>
            <div class="right">
                <div class="event-title">Events</div>
                <hr>
                <div class="events"></div>
            </div>

            <?php
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "laundry_db";

            // Create connection
                $conn = new mysqli($servername, $username, $password, $dbname);

            // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $query = "SELECT request_id, laundry_service_option, request_datetime, service_request_datetime FROM service_request";
                $result = $conn->query($query);

                if (!$result) {
                    die("Query failed: " . $conn->error);
                }

                            
            $events = array();

            while ($row = $result->fetch_assoc()) {
                $events[] = array(
                    'title' => $row['laundry_service_option'],
                    'start' => $row['request_datetime'],
                    'end' => $row['service_request_datetime'],
                );
            }

            // Close connection
            $conn->close();
            ?>

            <script>
                const calendar = document.querySelector(".calendar"),
                    date = document.querySelector(".date"),
                    daysContainer = document.querySelector(".days"),
                    prev = document.querySelector(".prev"),
                    next = document.querySelector(".next");

                let today = new Date();
                let activeDay;
                let month = today.getMonth();
                let year = today.getFullYear();

                const months = [
                    "January",
                    "February",
                    "March",
                    "April",
                    "May",
                    "June",
                    "July",
                    "August",
                    "September",
                    "October",
                    "November",
                    "December",
                ];

                // Function to add days in days with class day and prev-date next-date on previous month and next month days and active on today
                function initCalendar() {
                    const firstDay = new Date(year, month, 1);
                    const lastDay = new Date(year, month + 1, 0);
                    const prevLastDay = new Date(year, month, 0);
                    const prevDays = prevLastDay.getDate();
                    const lastDate = lastDay.getDate();
                    const day = firstDay.getDay();
                    const nextDays = 7 - lastDay.getDay() - 1;

                    date.innerHTML = months[month] + " " + year;

                    let days = "";
                    // Prev
                    for (let x = day; x > 0; x--) {
                        days += `<div class="day prev-date">${prevDays - x + 1}</div>`;
                    }

                    for (let i = 1; i <= lastDate; i++) {
                        // Check if event is present on that day
                        
                        const eventDate = new Date(year, month, i);
                        const eventsForDay = <?php echo json_encode($events); ?>.filter((event) => {
                            const eventDateTime = new Date(event.start);
                            return eventDateTime.getDate() === i && eventDateTime.getMonth() === month && eventDateTime.getFullYear() === year;
                        });

                        if (eventsForDay.length > 0) {
                            days += `<div class="day has-event mark">${i}</div>`; // Add the mark class
                        } else if (
                            i === new Date().getDate() &&
                            year === new Date().getFullYear() &&
                            month === new Date().getMonth()
                        ) {
                            days += `<div class="day today">${i}</div>`;
                        } else {
                            days += `<div class="day">${i}</div>`;
                        }
                    }

                    for (let j = 1; j < nextDays; j++) {
                        days += `<div class="day next-date">${j}</div>`;
                    }
                    
                    daysContainer.innerHTML = days;

                    
                }

                initCalendar();

                function prevMonth() {
                    month--;
                    if (month < 0) {
                        month = 11;
                        year--;
                    }      
                    initCalendar();
                }

                function nextMonth() {
                    month++;
                    if (month > 11) {
                        month = 0;
                        year++;
                    }
                    initCalendar();
                }

                prev.addEventListener("click", prevMonth);
                next.addEventListener("click", nextMonth);

                function displayEventsForDate(date, events) {
                    const eventsContainer = document.querySelector(".events");
                    let eventList = "";

                    events.forEach((event) => {
                        const eventDate = new Date(event.start);
                        if (eventDate.getDate() === date.getDate() && eventDate.getMonth() === date.getMonth() && eventDate.getFullYear() === date.getFullYear()) {
                            eventList += `
                                <hr><div class="event">
                                <h4><li>${event.title}</li></h4>
                                <p>Start: ${event.start}</p>
                                <p>End: ${event.end}</p>
                                </div></hr>
                            `;
                        }
                    });

                    eventsContainer.innerHTML = eventList;
                }

                daysContainer.addEventListener("click", (e) => {
                    if (e.target.classList.contains("day")) {
                        const day = parseInt(e.target.textContent);
                        const date = new Date(year, month, day);
                        displayEventsForDate(date, <?php echo json_encode($events); ?>);
                    }
                });

                displayEventsForDate(new Date().getDate(), <?php echo json_encode($events); ?>);
                </script>
            </div>
        </div><!--end of main-container-->    
    </body>

<script src="https://cdn.jsdelivr.net/npm/chart.js@3.8.0/dist/chart.min.js"></script>
<script src="Dashboard.js"></script>
</html>