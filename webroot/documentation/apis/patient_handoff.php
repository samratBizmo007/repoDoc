<h1 id="patient_handoff">Patient Handoff</h1>
							<!-- API URL -->
							<div class="bs-callout bs-callout-info">
								<h4><?php echo $DOC_URL ?>patientHandoff.json</h4>
							</div>
							<!-- REQUEST RESPONSE FORMAT -->
							<div class="highlight boderleft">
								<h4 class="colorblue">Supported Formats</h4>  
								<code class="colorblue">JSON</code>
								<code class="colorblue">XML</code>
								<br><br>
								<p class="colorred">*Default Response is in JSON</p>
							</div>

							<!-- REQUEST METHOD -->
							<h3 id="type23">Type</h3>
							<div class="bs-callout bs-callout-info">
								<h4>Type : <code>POST</code></h4>
							</div>

							<!-- REQUEST PARAMETERS -->
							<h3 id="input23">Input</h3>
							<div class="highlight boderleft">
								<pre >
									<code class="html">
user_token : "8942f8bec7f16962648b2f0f6d4dfb69ef43267b"
									</code>
									<p class="colorred">* HEADER PARAMETERS</p>
								</pre>
						 	</div>
						 	<div class="highlight boderleft">
								<pre >
									<code class="html">
{
	"patient_id" : "10"
}
   											
									</code>
									<p class="colorred">* REQUEST PARAMETERS</p>
								</pre>
						 	</div>

						 	<!-- RESPONSE -->
							<h3 id="output23">Output</h3>
							<div class="highlight boderleft">
								<h4 class="colorblue">success</h4>
								<pre >
									<code class="html">
{
    "status": 200,
    "message": "Success",
    "data": {
        "id": 10,
        "name": "Jason  Flores",
        "photo": "http://localhost/daily_doc/img/patients/thumbs/594cb8b0608f6.jpg",
        "mrn": "a206",
        "bed": "05760",
        "pmh": "",
        "age": 1,
        "gender": "Male",
        "admission_days": 37,
        "diagnosed_with": "",
        "patient_status": 1,
        "followup": {
            "id": 13,
            "content": "test2",
            "date": "19-07-17",
            "time": "12:09 am",
            "employee_name": "Poonam  Openxcell",
            "employee_photo": "http://localhost/daily_doc/admin/img/default.png",
            "employee_designation": "Consultant",
            "employee_department": "Eye"
        },
        "major_event": {
            "id": 9,
            "content": "http://localhost/daily_doc/audio/major_event/1500450438470.mp4",
            "event": "Hand",
            "date": "19-07-17",
            "time": "01:17 pm"
        },
        "signout_note": {
            "id": 20,
            "content": "http://localhost/daily_doc/audio/signout/1500549912617.mp4",
            "date": "30-05-17",
            "time": "05:30 am"
        }
    }
}

									</code>
								</pre>
						 	</div>

						 	<br>

						 	<div class="bs-callout bs-callout-danger">
								<h4 class="colorred">Bad Response</h4>
								<pre style="background-color:inherit;border:none;">
{
	"status":400,
	"message":"Invalid header passed."
}

{
	"status":401,
	"message":"You are unauthorized to access this location."
}

{
  "status": 403,
  "message": "Forbidden! You don't have permission to access this url."
}

{
  "status": 400,
  "message": "Insufficient parameters have been passed."
}

{
  "status": 500,
  "message": "Oops ! Something went wrong."
}
									<p class="colorred">* MESSAGE Showing Cause OF Issue In Human Readable Format</p>
								</pre>
					 		</div>