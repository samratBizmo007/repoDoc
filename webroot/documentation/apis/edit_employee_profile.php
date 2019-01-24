<h1 id="edit_employee_profile">Edit Employee Profile</h1>
							<!-- API URL -->
							<div class="bs-callout bs-callout-info">
								<h4><?php echo $DOC_URL ?>addPatientsOnDashboard.json</h4>
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
							<h3 id="type34">Type</h3>
							<div class="bs-callout bs-callout-info">
								<h4>Type : <code>POST</code></h4>
							</div>

							<!-- REQUEST PARAMETERS -->
							<h3 id="input34">Input</h3>
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
employee_id:275
photo: (uploaded file)
   											
									</code>
									<p class="colorred">* REQUEST PARAMETERS</p>
								</pre>
						 	</div>

						 	<!-- RESPONSE -->
							<h3 id="output34">Output</h3>
							<div class="highlight boderleft">
								<h4 class="colorblue">success</h4>
								<pre >
									<code class="html">
{
    "encript": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdGF0dXMiOjIwMCwibWVzc2FnZSI6IlN1Y2Nlc3MiLCJkYXRhIjp7ImlkIjoyNzUsImhvc3BpdGFsX2lkIjoxLCJwYXNzd29yZCI6IiQyeSQxMCRLUGZ0d294bUFxejFkSzduXC9tZjFaLlNldmFlM1wvbFhJSFVHOUMuNVJvOEZpRzNncmxRUXZlIiwiZW1haWwiOiJhaS5icmFrZXJAZGFpbHlkb2MuY29tIiwiZmlyc3RuYW1lIjoiQWkiLCJsYXN0bmFtZSI6IkJyYWtlciIsImVtcGxveWVlX3JvbGUiOiJEb2N0b3IiLCJkZXNpZ25hdGlvbiI6IkNoYWlyIE9mIFRoZSBEZXBhcnRtZW50IiwiZW1wbG95ZWVfcm9sZV9zaG9ydCI6IkRSIiwiZGVwYXJ0bWVudCI6IkRlbnRpc3RyeSIsInRpdGxlIjoiIiwicXVhbGlmaWNhdGlvbiI6Ik1EIiwicGhvdG8iOiJodHRwczpcL1wvZGFpbHlkb2NhcHAuY29tXC9pbWdcL2VtcGxveWVlc1wvb3JpZ2luYWxcLzViODUxMzJmYTM4MDguanBnIiwib2ZmaWNlX251bWJlciI6IjYxMjI3MzMwNTQiLCJjZWxsX251bWJlciI6IjYxMjYzNjg4NTQiLCJmYXhfbnVtYmVyIjoiNjEyMjc1MTA1NCIsInBhZ2VyX251bWJlciI6IiIsIndvcmtpbmdfdGltZSI6IiIsImFwcF90b2tlbiI6IjAwZWJiMzIwZGM4ODhkMzQzZGQwOGU0ZDhjM2ZhOTg4MTUzNTM2ODE1OSIsImlzX3dvcmtpbmciOjAsImRldmljZV90b2tlbiI6Ijc4MDI3NzNiNWIzZjQ2ZjU0Njk4NTNhMjY4YTBiYjhjMTQ5MzI4NzUyMiIsImRldmljZV90eXBlIjoxLCJidWlsZF92ZXJzaW9uIjoiMS4wLjAiLCJzdGF0dXMiOnRydWUsImlzX25vdGlmaWNhdGlvbiI6dHJ1ZSwiaG9zcGl0YWxzX2VtcGxveWVlcyI6W3siZW1wbG95ZWVfaWQiOjI3NSwiaG9zcGl0YWxfaWQiOi0xLCJzZXJ2aWNlX3RlYW1faWQiOi0xfV0sInBhc3N3b3JkX2V4cGlyZWQiOmZhbHNlLCJkZXBhcnRtZW50X2lkIjoxNDAsImVtcGxveWVlX2lkIjoyNzUsInBob3RvX25hbWUiOiI1Yjg1MTMyZmEzODA4LmpwZyIsInBob3RvX3RodW1iIjoiaHR0cHM6XC9cL2RhaWx5ZG9jYXBwLmNvbVwvaW1nXC9lbXBsb3llZXNcL29yaWdpbmFsXC81Yjg1MTMyZmEzODA4LmpwZyJ9fQ.77zQTKUxLduhVHR8YWQN5jE7yk8VOlRTk9zoU-4CYIo"
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