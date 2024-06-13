// var $ = require('jquery');
/*
I will need this templet many times ahead
$.ajax({
        url:"ajaxhandler/attendanceAJAX.php",
        type:"POST",
        dataType:"json",
        data:{},
        beforeSend:function(e)
        {

        },
        success:function(rv)
        {

        },
        error:function(e)
        {

        }
    });
*/
function saveAttendance(studentid, courseid, facultyid, sessionid, ondate, ispresent) {
    //ajax call to save attendance of students in DB
    // alert(studentid + " " + courseid + " " + facultyid + " " + sessionid + " " + ondate + " " + ispresent)
    $.ajax({
        url: "ajaxhandler/attendanceAJAX.php",
        type: "POST",
        dataType: "json",
        data: {
            studentid: studentid, courseid: courseid,
            facultyid: facultyid, sessionid: sessionid,
            ondate: ondate, ispresent: ispresent,
            action: "saveattendance"
        },
        beforeSend: function (e) {

        },
        success: function (rv) {
            // alert(ispresent)
            // alert(JSON.stringify(rv) + "\nAttendance saved");
        },
        error: function (e) {
            alert(JSON.stringify(e) + "\nError in saving attendance");
        }

    });
}
function getStudentListHTML(studentlist) {
    let html = `<div class="studentlist"><label>STUDENT LIST</label></div>`;
    for (let i = 0; i < studentlist.length; i++) {
        let student = studentlist[i];
        let checkedState = ``;
        if (student['isPresent'] == "NO") {
            checkedState = ``;
        }
        else {
            checkedState = `checked`;
        }
        html = html + `<div class="studentdetails">
            <div class="slno-area">${i + 1}</div>
            <div class="rollno-area">${student['roll_no']}</div>
            <div class="name-area">${student['name']}</div>
            <div class="checkbox-area" data-studentid='${student["id"]}'>
                <input type="checkbox" class="cbpresent" ${checkedState}>
            </div>
        </div>`;
    }

    return html;
}
function fetchStudentList($sessionid, $courseid, $facid, $ondate) {
    $.ajax({
        url: "ajaxhandler/attendanceAJAX.php",
        type: "POST",
        dataType: "json",
        data: {
            sessionid: $sessionid, courseid: $courseid,
            facid: $facid, ondate: $ondate, action: "getStudentList"
        },
        beforeSend: function (e) {

        },
        success: function (rv) {
            // alert(JSON.stringify(rv));
            let x = getStudentListHTML(rv);
            $("#studentlistarea").html(x);
        },
        error: function (e) {
            alert(JSON.stringify(e));
        }
    });
};
function getClassDetailsAreaHTML(classobj) {
    // alert(JSON.stringify(classobj));
    let dobj = new Date();
    let ondate = `2023-12-01`;
    let year = dobj.getFullYear();
    let month = dobj.getMonth() + 1;
    if (month < 10) month = "0" + month;
    let day = dobj.getDate();
    if (day < 10) day = "0" + day;  //required 2 letter sting
    ondate = year + "-" + month + "-" + day;
    // alert(ondate);
    let html = `<div class="classdetails">
        <div class="code-area">${classobj['code']}</div>
        <div class="title-area">${classobj['title']}</div>
        <div class="ondate-area">
            <input type="date" value="${ondate}" id="dtpondate">
        </div>
    </div>`;
    return html;
}
function getCourseCardHTML(subjectlist) {
    let html = "";
    for (let i = 0; i < subjectlist.length; i++) {
        let cc = subjectlist[i];
        // alert(JSON.stringify(cc));
        html += `<div class="classcard" data-classobj='${JSON.stringify(cc)}'>${cc['code']}</div>`;
    }
    return html;
}
function getSessionHTML(rv) {
    let html = "";
    if (rv.length > 0) {
        html += "<option value='-1'>Select Session</option>";
        for (let i = 0; i < rv.length; i++) {
            html += "<option value='" + rv[i].term + "'>" + rv[i].term + " semester " + rv[i].year + "</option>";
        }
    }
    return html;
}

function fetchFacultyCourses($facid, $sessionid) {
    $.ajax({
        url: "ajaxhandler/attendanceAJAX.php",
        type: "POST",
        dataType: "json",
        data: { action: "getFacultyCourses", facid: $facid, sessionid: $sessionid },
        beforeSend: function (e) {

        },
        success: function (rv) {
            // alert(JSON.stringify(rv));
            let x = getCourseCardHTML(rv);
            $("#classlistarea").html(x);
        },
        error: function (e) {

        }
    });

}

function loadSession() {
    $.ajax({        //ajax call to the server to get the session
        url: "ajaxhandler/attendanceAJAX.php",
        type: "POST",
        dataType: "json",
        data: { action: "getSession" },
        beforeSend: function (e) {

        },
        success: function (rv) { //rv is the response from the server in json format
            // alert(JSON.stringify(rv));
            // console.log("success");
            //creating html for the session
            let x = getSessionHTML(rv);
            $("#ddlclass").html(x);
        },
        error: function (e) {
            alert("Error: " + JSON.stringify(e));
            console.log("error");
        }
    })
}
$(function (e) {
    $(document).on("click", "#btnLogout", function (ee) {

    });
    loadSession();
    $(document).on("change", "#ddlclass", function (e) {
        $("#classlistarea").html(``);
        $("#classdetailsarea").html(``);
        $("#studentlistarea").html(``);
        let si = $("#ddlclass").val();
        if (si != -1) {
            // alert(si);
            let sessionid = si;
            let facid = $("#hdnfacid").val();
            fetchFacultyCourses(facid, sessionid);
        }
    })
    $(document).on("click", ".classcard", function (e) {
        let classobj = $(this).data("classobj");
        // alert(JSON.stringify(classobj));

        $("#hiddenSelectedCourseId").val(classobj['id']);

        let x = getClassDetailsAreaHTML(classobj);
        $("#classdetailsarea").html(x); //displaying the subject details

        let sessionid = $("#ddlclass").val();
        // alert(sessionid + " sid");
        let courseid = classobj['id'];
        // alert(courseid + " courseid<br>" + sessionid + " sid");
        let facid = $("#hdnfacid").val();
        let ondate = $("#dtpondate").val();
        if (sessionid != -1) {
            // to fetch the student list along with attendance we need to pass facid and ondate also
            let y = fetchStudentList(sessionid, courseid, facid, ondate);
        }
    });
    $(document).on("click", ".cbpresent", function (e) {
        // alert("ok");
        let ispresent = this.checked;
        if (ispresent) {
            ispresent = "YES";
        }
        else {
            ispresent = "NO";
        }
        // alert(ispresent);
        let studentid = $(this).parent().data('studentid');
        let courseid = $("#hiddenSelectedCourseId").val();
        let facultyid = $("#hdnfacid").val();
        let sessionid = $("#ddlclass").val();
        let ondate = $("#dtpondate").val();
        // alert(studentid + " " + courseid + " " + facultyid + " " + sessionid + " " + ondate + " " + ispresent);
        saveAttendance(studentid, courseid, facultyid, sessionid, ondate, ispresent);
    });
    $(document).on("change", "#dtpondate", function (e) {
        // alert("date changed" + $("#dtpondate").val());
        let sessionid = $("#ddlclass").val();
        let courseid = $("#hiddenSelectedCourseId").val();
        let facid = $("#hdnfacid").val();
        let ondate = $("#dtpondate").val();
        if (sessionid != -1) {
            // to fetch the student list along with attendance we need to pass facid and ondate also
            let y = fetchStudentList(sessionid, courseid, facid, ondate);
        }
    });

})