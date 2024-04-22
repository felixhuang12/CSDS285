<!DOCTYPE html>
<html>
<head>
    <title>CPU Data Plot</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@^4"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment@^2"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-moment@^1"></script>
</head>
<body>
    <?php

    // Execute commands to get CPU data
    $cpu_idle_output = shell_exec("cat ./datasets/top.txt | grep Cpu | cut -c 36-40");
    $cpu_user_output = shell_exec("cat ./datasets/top.txt | grep Cpu | cut -c 11-14");
    $cpu_system_output = shell_exec("cat ./datasets/top.txt | grep Cpu | cut -c 20-23");
    $cpu_wait_output = shell_exec("cat ./datasets/top.txt | grep Cpu | cut -c 46-49");
    $load_avg_five_mins_output = shell_exec("cat ./datasets/top.txt | grep days | cut -c 66-70");

    // Process CPU idle data
    function processData($output) {
        $NUM_DATA_POINTS = 12 * 24 * 2; // 1 every 5 minutes for 2 days
        $lines = explode(PHP_EOL, $output);
        $data = array();
        if (!empty($lines)) {
            foreach ($lines as $index => $line) {
                if (!empty($line)) {
                    $data[$index] = floatval(trim(str_replace(',', '', $line)));
                }
            }
        }

        if (count($data) < $NUM_DATA_POINTS) {
            $data = array_pad($data, -$NUM_DATA_POINTS, -0.01);
        }

        return array_slice($data, count($data) - $NUM_DATA_POINTS);
    }
    $cpu_idle_data = processData($cpu_idle_output);
    $cpu_user_data = processData($cpu_user_output);
    $cpu_system_data = processData($cpu_system_output);
    $cpu_wait_data = processData($cpu_wait_output);
    $load_avg_five_mins_data = processData($load_avg_five_mins_output);

    ?>
    <canvas id="cpuIdleChart"></canvas>
    <canvas id="cpuUserChart"></canvas>
    <canvas id="cpuSysChart"></canvas>
    <canvas id="cpuWaitChart"></canvas>
    <canvas id="loadAvgChart"></canvas>
    <script>

        // Get CPU data from PHP variables
        const cpuIdleData = <?php echo json_encode($cpu_idle_data); ?>;
        const cpuUserData = <?php echo json_encode($cpu_user_data); ?>;
        const cpuSysData = <?php echo json_encode($cpu_system_data); ?>;
        const cpuWaitData = <?php echo json_encode($cpu_wait_data); ?>;
        const loadAvgData = <?php echo json_encode($load_avg_five_mins_data); ?>;

        function generateDatesAndTimestamps() {
            var datesAndTimestamps = [];
            var currentDate = new Date();
            var oneWeekAgo = new Date(currentDate);
            oneWeekAgo.setDate(oneWeekAgo.getDate() - 2);

            // Loop through each 5-minute interval for the past week
            while (oneWeekAgo <= currentDate) {
                datesAndTimestamps.push({
                    date: oneWeekAgo.toLocaleString().replace(/:\d\d /, ' '),
                    timestamp: oneWeekAgo.getTime()
                });
                oneWeekAgo.setMinutes(oneWeekAgo.getMinutes() + 5);
            }
            return datesAndTimestamps;
        }

        // Generate dates and timestamps
        const datesAndTimestamps = generateDatesAndTimestamps();

        function generateChart(title, data, elementId) {
            const chartData = {
                labels: datesAndTimestamps.map(entry => entry.date),
                datasets: [
                    {
                        label: title,
                        data: data,
                        borderColor: '#' + (Math.random() * 0xFFFFFF << 0).toString(16),
                        backgroundColor: 'rgba(0, 0, 0, 0)',
                        borderWidth: 1
                    },
                ]
            };

            // Chart configuration
            const chartConfig = {
                type: 'line',
                data: chartData,
                options: {
                    scales: {
                        x: {
                            type: 'time',
                            time: {
                                unit: 'day',
                                tooltipFormat: 'MMM DD, YYYY HH:mm'
                            },
                            ticks: {
                                source: 'data',
                                maxTicksLimit: 3
                            },
                            title: {
                                display: true,
                                text: 'Time'
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Value'
                            }
                        }
                    }
                }
            };
            const ctx = document.getElementById(elementId).getContext('2d');
            return new Chart(ctx, chartConfig);
        }

        const cpuIdleChart = generateChart('CPU Idle', cpuIdleData, 'cpuIdleChart');
        const cpuUserChart = generateChart('CPU User', cpuUserData, 'cpuUserChart');
        const cpuSysChart = generateChart('CPU System', cpuSysData, 'cpuSysChart');
        const cpuWaitChart = generateChart('CPU Wait', cpuWaitData, 'cpuWaitChart');
        const loadAvgChart = generateChart('Load Average (5 mins)', loadAvgData, 'loadAvgChart');
    </script>
</body>
</html>
