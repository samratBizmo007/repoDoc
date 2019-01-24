<h1 id="all_patient_followups">All Patient Followups</h1>
							<!-- API URL -->
							<div class="bs-callout bs-callout-info">
								<h4><?php echo $DOC_URL ?>getAllPatientFollowups.json</h4>
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
							<h3 id="type35">Type</h3>
							<div class="bs-callout bs-callout-info">
								<h4>Type : <code>POST</code></h4>
							</div>

							<!-- REQUEST PARAMETERS -->
							<h3 id="input35">Input</h3>
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
token:eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJob3NwaXRhbF9pZCI6IjEiLCJlbXBsb3llZV9pZCI6IjM0NCIsInNlcnZpY2VfdGVhbV9pZCI6IjEyIn0.IAOol3FP6QtpSrbBEPkRy9OiwNQaVV79niOVT2RVrKs								
									</code>
									<p class="colorred">* REQUEST PARAMETERS</p>
								</pre>
						 	</div>

						 	<!-- RESPONSE -->
							<h3 id="output35">Output</h3>
							<div class="highlight boderleft">
								<h4 class="colorblue">success</h4>
								<pre >
									<code class="html">
{
    "encript": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdGF0dXMiOjIwMCwibWVzc2FnZSI6IlN1Y2Nlc3MiLCJkYXRhIjpbeyJpZCI6MTQsIm5hbWUiOiJMdWNhcyBXaGl0ZSIsInBob3RvIjoiaHR0cHM6XC9cL2RhaWx5ZG9jYXBwLmNvbVwvYWRtaW5cL2ltZ1wvcGF0aWVudC1kZWZhdWx0LnBuZyIsIm1ybiI6Ijk4Mzc4MTQiLCJiZWQiOiI3LTIiLCJwbWgiOiJETVxuSFRcbkNBQkdcbiIsImFnZSI6MzIsImdlbmRlciI6Ik1hbGUiLCJhZG1pc3Npb25fZGF5cyI6MzAyLCJkaWFnbm9zZWRfd2l0aCI6IkhUXG5DQU5HIiwicGF0aWVudF9zdGF0dXMiOjQsImZvbGxvd3VwcyI6W3siaWQiOjEyMywiY29udGVudCI6ImxhdGUgZm9yIHNpZ25vdXQiLCJkYXRlIjoiMDUtMDYtMTgiLCJ0aW1lIjoiMDg6MDUgYW0iLCJzdGF0dXMiOnRydWUsImVtcGxveWVlX25hbWUiOiJLaGFuZHVyYW8gS2hvdCIsImVtcGxveWVlX3Bob3RvIjoiaHR0cHM6XC9cL2RhaWx5ZG9jYXBwLmNvbVwvYWRtaW5cL2ltZ1wvZGVmYXVsdC5wbmciLCJlbXBsb3llZV9kZXNpZ25hdGlvbiI6Ikhvc3BpdGFsaXN0IiwiZW1wbG95ZWVfZGVwYXJ0bWVudCI6IkludGVybmFsIE1lZGljaW5lIiwiZW1wbG95ZWVfcm9sZSI6IkRvY3RvciIsImVtcGxveWVlX3JvbGVfc2hvcnQiOiJEUiJ9LHsiaWQiOjEyNCwiY29udGVudCI6InRlc3Q3MDgiLCJkYXRlIjoiMDgtMDYtMTgiLCJ0aW1lIjoiMDc6MDkgcG0iLCJzdGF0dXMiOnRydWUsImVtcGxveWVlX25hbWUiOiJLaGFuZHVyYW8gS2hvdCIsImVtcGxveWVlX3Bob3RvIjoiaHR0cHM6XC9cL2RhaWx5ZG9jYXBwLmNvbVwvYWRtaW5cL2ltZ1wvZGVmYXVsdC5wbmciLCJlbXBsb3llZV9kZXNpZ25hdGlvbiI6Ikhvc3BpdGFsaXN0IiwiZW1wbG95ZWVfZGVwYXJ0bWVudCI6IkludGVybmFsIE1lZGljaW5lIiwiZW1wbG95ZWVfcm9sZSI6IkRvY3RvciIsImVtcGxveWVlX3JvbGVfc2hvcnQiOiJEUiJ9XX0seyJpZCI6MjIsIm5hbWUiOiJIZW5yeSBSb2RyaWd1ZXoiLCJwaG90byI6Imh0dHBzOlwvXC9kYWlseWRvY2FwcC5jb21cL2FkbWluXC9pbWdcL3BhdGllbnQtZGVmYXVsdC5wbmciLCJtcm4iOiI5ODM3ODIyIiwiYmVkIjoiMTEtMiIsInBtaCI6ImNhYmdcbmRtXG5odFxuY2hvXG5hY3V0ZSBjaG9sZSAiLCJhZ2UiOjQ0LCJnZW5kZXIiOiJNYWxlIiwiYWRtaXNzaW9uX2RheXMiOjMwMywiZGlhZ25vc2VkX3dpdGgiOiJmZXZlclxudXRpXG5zZXBzaXNcbmRjaGZcbmxhcCBjaG9sZSIsInBhdGllbnRfc3RhdHVzIjoxLCJmb2xsb3d1cHMiOlt7ImlkIjoxNjAsImNvbnRlbnQiOiJieG5kbmQiLCJkYXRlIjoiMDQtMDgtMTgiLCJ0aW1lIjoiMDk6MjUgYW0iLCJzdGF0dXMiOnRydWUsImVtcGxveWVlX25hbWUiOiJLaGFuZHVyYW8gS2hvdCIsImVtcGxveWVlX3Bob3RvIjoiaHR0cHM6XC9cL2RhaWx5ZG9jYXBwLmNvbVwvYWRtaW5cL2ltZ1wvZGVmYXVsdC5wbmciLCJlbXBsb3llZV9kZXNpZ25hdGlvbiI6Ikhvc3BpdGFsaXN0IiwiZW1wbG95ZWVfZGVwYXJ0bWVudCI6IkludGVybmFsIE1lZGljaW5lIiwiZW1wbG95ZWVfcm9sZSI6IkRvY3RvciIsImVtcGxveWVlX3JvbGVfc2hvcnQiOiJEUiJ9LHsiaWQiOjE2MiwiY29udGVudCI6ImFkZCBvbmUiLCJkYXRlIjoiMDQtMDgtMTgiLCJ0aW1lIjoiMDk6MjYgYW0iLCJzdGF0dXMiOnRydWUsImVtcGxveWVlX25hbWUiOiJLaGFuZHVyYW8gS2hvdCIsImVtcGxveWVlX3Bob3RvIjoiaHR0cHM6XC9cL2RhaWx5ZG9jYXBwLmNvbVwvYWRtaW5cL2ltZ1wvZGVmYXVsdC5wbmciLCJlbXBsb3llZV9kZXNpZ25hdGlvbiI6Ikhvc3BpdGFsaXN0IiwiZW1wbG95ZWVfZGVwYXJ0bWVudCI6IkludGVybmFsIE1lZGljaW5lIiwiZW1wbG95ZWVfcm9sZSI6IkRvY3RvciIsImVtcGxveWVlX3JvbGVfc2hvcnQiOiJEUiJ9XX1dfQ.RLWor9CZN_Kn_b018t35fJJWTGhqAeUfJyxCV8Vhb3Y"
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

									<p class="colorred">* MESSAGE Showing Cause OF Issue In Human Readable Format</p>
								</pre>
					 		</div>