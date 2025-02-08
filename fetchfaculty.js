async function fetchFacultyData() {
    try {
        let response = await fetch("../back/fetch_faculty_data.php");
        let data = await response.json();
        displayFacultyData(data);
    } catch (error) {
        console.error("Error fetching faculty data:", error);
    }
}

function displayFacultyData(facultyData) {
    const tableBody = document.getElementById("faculty-table-body");

    tableBody.innerHTML = '';

    facultyData.forEach((faculty) => {
        let row = document.createElement("tr");
        row.innerHTML = `
            <td>${faculty.faculty_id}</td>
            <td>${faculty.firstname}</td>
            <td>${faculty.middlename}</td>
            <td>${faculty.lastname}</td>
            <td>${faculty.college}</td>
            <td>${faculty.employment_status}</td>
            <td>${faculty.address}</td>
            <td>${faculty.phone_no}</td>
            <td>${faculty.departmentID}</td>
            <td>${faculty.department_title}</td>
            <td>${faculty.subject}</td>
            <td>${faculty.role}</td>
            <td>${faculty.master_specialization}</td>
            <td>
                <a href="faculty.php?id=${faculty.faculty_id}&department=${faculty.departmentID}&action=edit">
                    <button class="edit-btn"> Edit</button>
                </a>
                <button class="delete-btn" onclick="confirmDeleteFaculty('${faculty.faculty_id}','${faculty.departmentID}')">
                    Delete
                </button>
                <a href='../frame/info.php?id=${faculty.faculty_id}'><button class='schedule-btn'>View Profile</button></a>
            </td>
        `;
        tableBody.appendChild(row);
    });
}

function downloadExcel() {
    let table = document.getElementById("faculty-table");
    if (!table) {
        console.error("Table not found!");
        return;
    }

    let clonedTable = table.cloneNode(true);
    let rows = clonedTable.querySelectorAll("tr");

    rows.forEach(row => {
        let lastColumn = row.querySelectorAll("td, th").length - 1;
        if (row.querySelectorAll("td").length > 0) {
            row.removeChild(row.querySelectorAll("td")[lastColumn]);
        }
    });

    let ws = XLSX.utils.table_to_sheet(clonedTable);
    let wb = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(wb, ws, "Faculty Data");

    XLSX.writeFile(wb, "Faculty_List.xlsx");
}

fetchFacultyData();

