<?php
include_once "../back/sections.php";

error_log(print_r($sections, true));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Section Management - <?php echo htmlspecialchars($dep); ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #f4f6f9;
            color: #333;
            padding: 20px;
        }

        .container {
            padding: 30px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            max-width: 1200px;
            margin: 0 auto;
        }

        h2 {
            font-size: 28px;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 25px;
        }

        .toolbar {
            background: #34495e;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .toolbar h3 {
            color: white;
            font-size: 16px;
            font-weight: 500;
        }

        .toolbar-controls {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .filter-section {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .filter-title {
            color: white;
            font-weight: 500;
            font-size: 14px;
        }

        .filter-items {
            display: flex;
            gap: 10px;
        }

        .filter-item {
            background-color: #e9ecef;
            padding: 5px 10px;
            border-radius: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 13px;
        }

        .filter-item:hover {
            background-color: #00c4b4;
            color: white;
        }

        .filter-item.active {
            background-color: #00c4b4;
            color: white;
        }

        .search-container {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .search-box {
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            width: 220px;
            font-size: 14px;
            transition: border-color 0.3s ease;
        }

        .search-box:focus {
            outline: none;
            border-color: #00c4b4;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 6px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
        }

        th {
            background-color: #f8f9fa;
            font-weight: 600;
            color: #2c3e50;
            font-size: 14px;
            text-transform: uppercase;
        }

        td {
            font-size: 14px;
            color: #555;
        }

        tr:nth-child(even) {
            background-color: #fafafa;
        }

        tr:hover {
            background-color: #f1f3f5;
        }

        button {
            padding: 8px 16px;
            background-color: #00c4b4;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 500;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #00a99d;
        }

        .pagination {
            display: flex;
            gap: 10px;
            justify-content: center;
            align-items: center;
            margin-top: 25px;
        }

        .pagination a {
            padding: 8px 14px;
            border-radius: 6px;
            background-color: #00c4b4;
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: background-color 0.3s ease;
        }

        .pagination a:hover {
            background-color: #00a99d;
        }

        .pagination strong {
            padding: 8px 14px;
            border-radius: 6px;
            background-color: #34495e;
            color: white;
            font-weight: 500;
        }

        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }
            .toolbar {
                flex-direction: column;
                gap: 15px;
            }
            .toolbar-controls {
                flex-direction: column;
                width: 100%;
                gap: 15px;
            }
            .filter-section {
                flex-direction: column;
                align-items: flex-start;
            }
            .search-box {
                width: 100%;
            }
            th, td {
                padding: 10px;
                font-size: 12px;
            }
            button {
                width: 100%;
            }
            .pagination {
                flex-wrap: wrap;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2><?php echo htmlspecialchars($dep); ?> Sections List</h2>

        <div class="toolbar">
            <h3>Sections</h3>
            <div class="toolbar-controls">
                <div class="filter-section">
                    <span class="filter-title">Year Level:</span>
                    <div class="filter-items" id="yearFilter">
                        <?php
                        $years = [1, 2, 3, 4];
                        foreach ($years as $year) {
                            $count = array_reduce($sections, function($carry, $section) use ($year) {
                                return $carry + ($section['year_level'] == $year ? 1 : 0);
                            }, 0);
                            echo "<span class='filter-item' data-filter='year' data-value='$year'>$year</span>";
                        }
                        ?>
                    </div>
                </div>
                <div class="search-container">
                    <input type="text" placeholder="Search sections..." class="search-box">
                </div>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Department</th>
                    <th>Year/Section</th>
                    <th>Year Level</th>
                    <th>Semestrial</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($sections)) : ?>
                    <?php foreach ($sections as $section) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($section['program_code']); ?></td>
                            <td><?php echo htmlspecialchars($section['section_name']); ?></td>
                            <td><?php echo htmlspecialchars($section['year_level']); ?></td>
                            <td><?php echo htmlspecialchars($section['semester']); ?></td>
                            <td>
                                <button onclick="window.location.href='manual_scheduling.php?section_id=<?php echo urlencode($section['section_id']); ?>&department=<?php echo urlencode($section['program_code']); ?>'">View Schedule</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="5" style="text-align:center;">No sections added yet.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.querySelector('.search-box');
        const tableRows = document.querySelectorAll('tbody tr');
        const filterItems = document.querySelectorAll('.filter-item');
        let activeFilters = { year: null };

        searchInput.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            filterTable(searchTerm, activeFilters);
        });

        filterItems.forEach(item => {
            item.addEventListener('click', function() {
                const filterType = this.getAttribute('data-filter');
                const filterValue = this.getAttribute('data-value');

                if (activeFilters[filterType] === filterValue) {
                    activeFilters[filterType] = null;
                    this.classList.remove('active');
                } else {
                    document.querySelectorAll(`[data-filter="${filterType}"]`).forEach(el => {
                        el.classList.remove('active');
                    });
                    activeFilters[filterType] = filterValue;
                    this.classList.add('active');
                }

                filterTable(searchInput.value.toLowerCase(), activeFilters);
            });
        });

        function filterTable(searchTerm, filters) {
            tableRows.forEach(row => {
                const programCode = row.cells[0].textContent.toLowerCase();
                const sectionName = row.cells[1].textContent.toLowerCase();
                const yearLevel = row.cells[2].textContent;
                const semester = row.cells[3].textContent.toLowerCase();

                let matchesYear = true;
                if (filters.year) {
                    matchesYear = yearLevel === filters.year;
                }

                let matchesSearch = true;
                if (searchTerm) {
                    matchesSearch = (
                        programCode.includes(searchTerm) ||
                        sectionName.includes(searchTerm) ||
                        semester.includes(searchTerm)
                    );
                }

                row.style.display = (matchesYear && matchesSearch) ? '' : 'none';
            });

            const visibleRows = Array.from(tableRows).filter(row => row.style.display !== 'none');
            const noResultsRow = document.querySelector('tbody tr td[colspan="5"]');
            if (noResultsRow) {
                noResultsRow.parentElement.style.display = visibleRows.length === 0 ? '' : 'none';
            }
        }
    });
    </script>
</body>
</html>