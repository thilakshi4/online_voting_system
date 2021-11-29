    function loadPPData() {

        setInterval(function () {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("data_pp_number").innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", "data_pp_requests.php", true);
            xhttp.send();

        }, 1000);
    }

    loadPPData();
    
    function loadCandidateData() {

        setInterval(function () {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("candidate_reg_req").innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", "data_candidate_requests.php", true);
            xhttp.send();

        }, 1000);
    }
    loadCandidateData();

    function loadDOData() {

        setInterval(function () {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("do_number").innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", "data_do_data.php", true);
            xhttp.send();

        }, 1000);
    }
    loadDOData();

    function loadAdminData() {

        setInterval(function () {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("ad_number").innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", "data_ec_data.php", true);
            xhttp.send();

        }, 1000);
    }
    loadAdminData();
    

    //load voter requests
     function loadVoterData() {

        setInterval(function () {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState === 4 && this.status === 200) {
                    document.getElementById("v_number").innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", "data_voter_requests.php", true);
            xhttp.send();

        }, 1000);
    }
    loadVoterData();
    
        function loadVoterPersonnalData() {

        setInterval(function () {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState === 4 && this.status === 200) {
                    document.getElementById("vpdc_number").innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", "data_personal_dc_requests.php", true);
            xhttp.send();

        }, 1000);
    }
    loadVoterPersonnalData();
    
            function loadVoterResidentialData() {

        setInterval(function () {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState === 4 && this.status === 200) {
                    document.getElementById("vrdc_number").innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", "data_residential_dc_requests.php", true);
            xhttp.send();

        }, 1000);
    }
    loadVoterResidentialData();

       function loadGNData() {

        setInterval(function () {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("gn_number").innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", "data_gn_data.php", true);
            xhttp.send();

        }, 1000);
    }
    loadGNData();


