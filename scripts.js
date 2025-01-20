// load frame
function loadFrame(page,role,department) {
    const basePath = "/facultyloading/frame/";
    document.getElementById("frame").src = basePath + page + ".php?role="+role+"&department="+department;
}
// modal for adding program
var modal = document.getElementById("addProgramModal");
var btn = document.querySelector(".add-new");
var span = document.querySelector(".close-btn");

btn.onclick = function() {
    modal.style.display = "block";
}

span.onclick = function() {
    modal.style.display = "none";
}

window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

function confirmDelete(programCode) {
    if (confirm("Are you sure you want to delete this program?")) {
        window.location.href = "/facultyloading/back/actions.php?action=delete&program_code=" + programCode;
    }
}

// modal for editting program
function openEditProgramModal(programCode, programName, college) {
    try {

        document.getElementById('editProgramCode').value = programCode || '';
        document.getElementById('editProgramName').value = programName || '';
        document.getElementById('editCollege').value = college || '';

        document.getElementById('editProgramModal').style.display = 'block';
    } catch (error) {
        console.error('Error opening edit program modal:', error);
        alert('Failed to open the edit program modal. Please try again.');
    }
}

function closeEditModal() {
    document.getElementById('editProgramModal').style.display = 'none';
}



// modal for adding course
function openAddCourseModal() {
    document.getElementById('addCourseModal').style.display = 'block';
}
function closeAddCourseModal() {
    document.getElementById('addCourseModal').style.display = 'none';
}

// Modal for editting course
function openEditCourseModal(course) {
    try {
        let courseData = JSON.parse(course);

        document.getElementById('edit_course_id').value = courseData.course_id || '';
        document.getElementById('edit_subject_code').value = courseData.subject_code || '';
        document.getElementById('edit_course_title').value = courseData.course_title || '';
        document.getElementById('edit_year_level').value = courseData.year_level || '';
        document.getElementById('edit_semester').value = courseData.semester || '';
        document.getElementById('edit_lecture_hours').value = courseData.lecture_hours || '';
        document.getElementById('edit_lab_hours').value = courseData.lab_hours || '';
        document.getElementById('edit_credit_units').value = courseData.credit_units || '';
        document.getElementById('edit_slots').value = courseData.slots || '';

        document.getElementById('editCourseModal').style.display = 'block';
    } catch (error) {
        console.error('Error opening edit course modal:', error);
        alert('Failed to open the edit modal. Please try again.');
    }
}

function closeEditCourseModal() {
    document.getElementById('editCourseModal').style.display = 'none';
}

function isCourseCodeDuplicate(courseCode) {
    let duplicate = false;
    document.querySelectorAll('table tbody tr').forEach(function(row) {
        const existingCourseCode = row.querySelector('td:first-child').textContent.trim();
        if (existingCourseCode === courseCode) {
            duplicate = true;
        }
    });
    return duplicate;
}

document.getElementById('addCourseForm').onsubmit = function(event) {
    const courseCode = document.getElementById('subject_code').value;
    if (isCourseCodeDuplicate(courseCode)) {
        alert('Course code already exists!');
        event.preventDefault();
    }
};

//modal for class adding
function openAddClassModal() {
    document.getElementById('addClassModal').style.display = 'block';
}

function closeAddClassModal() {
    document.getElementById('addClassModal').style.display = 'none';
}


//modal for editting class
// // Open the Edit Class Modal
function openEditClassModal(sectionId, yearSection) {
    document.getElementById("edit_section_id").value = sectionId;
    document.getElementById("edit_year_section").value = yearSection;
    document.getElementById("editClassModal").style.display = "block";
}

function closeEditClassModal() {
    document.getElementById("editClassModal").style.display = "none";
}

// modal for adding faculty
function openAddNewModal() {
    const modal = document.getElementById('newFacultyModal'); 
    modal.style.display = 'block';
}
function closeAddNewModal() {
    const modal = document.getElementById('newFacultyModal'); 
    modal.style.display = 'none';
}
//******************************* */
// modal for editting faculty
function openEditFacultyModal() {
    const modal = document.getElementById('editFacultyModal'); 
    modal.style.display = 'block';
}
function closeEditFacultyModal() {
    const modal = document.getElementById('editFacultyModal'); 
    modal.style.display = 'none';
}
//******************************* */

function confirmDeleteFaculty(selectedFaculty, department) {
    if (confirm("Are you sure you want to delete this program?")) {
        window.location.href = "/facultyloading/back/faculty.php?action=delete&id=" + selectedFaculty+"&department="+ department;
    }
}

// modal for adding room
function openAddRoomModal() {
    const modal = document.getElementById('openAddRoomModal'); 
    modal.style.display = 'block';
}
function closeAddRoomModal() {
    const modal = document.getElementById('openAddRoomModal'); 
    modal.style.display = 'none';
}

// delete confirmation for room
function deleteRoomComfirm(building, room){
    if(confirm("are you sure you want to delete this room?")){
        window.location.href = "/facultyloading/back/rooms.php?building="+building+"&room="+room+"&action=delete";
    }
}

// openEditRoomModal
function openEditRoomModal() {
    
    document.getElementById('openEditRoomModal').style.display = 'block';
}

function closeEditRoomModal() {
    document.getElementById('openEditRoomModal').style.display = 'none';
}
