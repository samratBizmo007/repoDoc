<h1 id="patient_signout_notes">Patient Signout Notes</h1>
							<!-- API URL -->
							<div class="bs-callout bs-callout-info">
								<h4><?php echo $DOC_URL ?>patientViewNotes.json</h4>
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
							<h3 id="type10">Type</h3>
							<div class="bs-callout bs-callout-info">
								<h4>Type : <code>POST</code></h4>
							</div>

							<!-- REQUEST PARAMETERS -->
							<h3 id="input10">Input</h3>
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
	"patient_id" : "6"
}
   											
									</code>
									<p class="colorred">* REQUEST PARAMETERS</p>
								</pre>
						 	</div>

						 	<!-- RESPONSE -->
							<h3 id="output10">Output</h3>
							<div class="highlight boderleft">
								<h4 class="colorblue">success</h4>
								<pre >
									<code class="html">
{
  "status": 200,
  "message": "Success",
  "data": [
    {
      "id": 3,
      "employee_id": 3,
      "content": "this is testing followups first time",
      "date": "30-05-17",
      "time": "05:30 am",
      "name": "Euler  Openxcell",
      "photo": "http://localhost/daily_doc/admin/img/default.png",
      "designation": "Consultant",
      "department": "Consultant"
    },
    {
      "id": 2,
      "employee_id": 4,
      "content": "Naresh Kothiya",
      "date": "27-05-17",
      "time": "10:00 am",
      "name": "Gladys  Perlman",
      "photo": "http://localhost/daily_doc/admin/img/default.png",
      "designation": "Hand",
      "department": "Eye"
    },
    {
      "id": 1,
      "employee_id": 3,
      "content": "this is testting",
      "date": "27-05-17",
      "time": "08:30 am",
      "name": "Euler  Openxcell",
      "photo": "http://localhost/daily_doc/admin/img/default.png",
      "designation": "Consultant",
      "department": "Consultant"
    }
  ]
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