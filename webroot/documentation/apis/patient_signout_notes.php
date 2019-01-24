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
Token:00ebb320dc888d343dd08e4d8c3fa9881535368159
									</code>
									<p class="colorred">* HEADER PARAMETERS</p>
								</pre>
						 	</div>
						 	<div class="highlight boderleft">
								<pre >
									<code class="html">
token:eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJwYXRpZW50X2lkIjozNn0.uTPypOa2H-ne7YPGNlqN9eQW1HOFaxVxfmH4NWqTpU8   											
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
    "encript": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdGF0dXMiOjIwMCwibWVzc2FnZSI6IlN1Y2Nlc3MiLCJkYXRhIjpbeyJpZCI6NiwiZW1wbG95ZWVfaWQiOjEwNSwiY29udGVudCI6IiIsImR1cmF0aW9uIjoiMDA6MDA6MDMiLCJkYXRlIjoiMTItMDItMTgiLCJ0aW1lIjoiMDM6MDIgcG0iLCJuYW1lIjoiQ2FuZGljZSBSYWJpbCIsInBob3RvIjoiaHR0cHM6XC9cL2RhaWx5ZG9jYXBwLmNvbVwvYWRtaW5cL2ltZ1wvZGVmYXVsdC5wbmciLCJkZXNpZ25hdGlvbiI6IkFzc29jaWF0ZSBQcm9mZXNzb3IiLCJkZXBhcnRtZW50IjoiUGVkaWF0cmljIE5ldXJvbG9neSIsImVtcGxveWVlX3JvbGUiOiJEb2N0b3IiLCJlbXBsb3llZV9yb2xlX3Nob3J0IjoiRFIifSx7ImlkIjo0LCJlbXBsb3llZV9pZCI6MTA1LCJjb250ZW50IjoiIiwiZHVyYXRpb24iOiIwMDowMDowNCIsImRhdGUiOiIxMi0wMi0xOCIsInRpbWUiOiIwMjo0MyBwbSIsIm5hbWUiOiJDYW5kaWNlIFJhYmlsIiwicGhvdG8iOiJodHRwczpcL1wvZGFpbHlkb2NhcHAuY29tXC9hZG1pblwvaW1nXC9kZWZhdWx0LnBuZyIsImRlc2lnbmF0aW9uIjoiQXNzb2NpYXRlIFByb2Zlc3NvciIsImRlcGFydG1lbnQiOiJQZWRpYXRyaWMgTmV1cm9sb2d5IiwiZW1wbG95ZWVfcm9sZSI6IkRvY3RvciIsImVtcGxveWVlX3JvbGVfc2hvcnQiOiJEUiJ9LHsiaWQiOjMsImVtcGxveWVlX2lkIjoxMDUsImNvbnRlbnQiOiIiLCJkdXJhdGlvbiI6IjAwOjAwOjA1IiwiZGF0ZSI6IjEyLTAyLTE4IiwidGltZSI6IjAyOjM4IHBtIiwibmFtZSI6IkNhbmRpY2UgUmFiaWwiLCJwaG90byI6Imh0dHBzOlwvXC9kYWlseWRvY2FwcC5jb21cL2FkbWluXC9pbWdcL2RlZmF1bHQucG5nIiwiZGVzaWduYXRpb24iOiJBc3NvY2lhdGUgUHJvZmVzc29yIiwiZGVwYXJ0bWVudCI6IlBlZGlhdHJpYyBOZXVyb2xvZ3kiLCJlbXBsb3llZV9yb2xlIjoiRG9jdG9yIiwiZW1wbG95ZWVfcm9sZV9zaG9ydCI6IkRSIn1dfQ.dF88JMFDHx5RCMzJ49EF4Yx3ygZ7gcxe9KzewAHV-Gg"
}
									</code>
								</pre>
						 	</div>

						 	<br>

						 	<div class="bs-callout bs-callout-danger">
								<h4 class="colorred">Bad Response</h4>
								<pre style="background-color:inherit;border:none;">
{
    "encript": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdGF0dXMiOjQwMCwibWVzc2FnZSI6Imluc3VmZmljaWVudCBwYXJhbWV0ZXJzIn0.HEqSL2ckJ8hlCAbLKIVYmzM2bdKkXKPbVNC3LsA5R7I"
}

{
    "encript": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdGF0dXMiOjQwMywibWVzc2FnZSI6ImZvcmJpZGRlbiJ9.AvSXtHClYOacV0aDAJrERaLbWuvNcJZzMJuI_fhFcIA"
}

{
    "encript": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdGF0dXMiOjQwMCwibWVzc2FnZSI6IkludmFsaWQgaGVhZGVyIHBhc3NlZC4ifQ.Y4Jeb0RFe89kh4-G4rD7HWG_kbAcET5o4uFE8W9-_ZA"
}

{
    "encript": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdGF0dXMiOjQwMSwibWVzc2FnZSI6IllvdSBhcmUgdW5hdXRob3JpemVkIHRvIGFjY2VzcyB0aGlzIGxvY2F0aW9uLiJ9.As058aErTIv1Jbqnj4w5MdMzTvshS411w7ZoHc3Te_M"
}

{
    "encript": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdGF0dXMiOjUwMCwibWVzc2FnZSI6Ik9vcHMgISBTb21ldGhpbmcgd2VudCB3cm9uZy4ifQ.Wb-KLc0jy7_FDdXCK0NsbXNSxU0kgw7fBgjRRk4jUSE"
}
									<p class="colorred">* MESSAGE Showing Cause OF Issue In Human Readable Format</p>
								</pre>
					 		</div>