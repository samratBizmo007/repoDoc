<h1 id="employee_detail">Create Followups</h1>
							<!-- API URL -->
							<div class="bs-callout bs-callout-info">
								<h4><?php echo $DOC_URL ?>getEmployeeDetail.json</h4>
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
							<h3 id="type22">Type</h3>
							<div class="bs-callout bs-callout-info">
								<h4>Type : <code>POST</code></h4>
							</div>

							<!-- REQUEST PARAMETERS -->
							<h3 id="input22">Input</h3>
							<div class="highlight boderleft">
								<pre >
									<code class="html">
Token : "00ebb320dc888d343dd08e4d8c3fa9881535368159"
									</code>
									<p class="colorred">* HEADER PARAMETERS</p>
								</pre>
						 	</div>
						 	<div class="highlight boderleft">
								<pre >
									<code class="html">

token : eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbXBsb3llZV9pZCI6Mjc1fQ.kBWmKZu830GkYef2YXMcU_9g-BQosc-mWPetB064sjw

   											
									</code>
									<p class="colorred">* REQUEST PARAMETERS</p>
								</pre>
						 	</div>

						 	<!-- RESPONSE -->
							<h3 id="output22">Output</h3>
							<div class="highlight boderleft">
								<h4 class="colorblue">success</h4>
								<pre >
									<code class="html">
{
    "encript": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdGF0dXMiOjIwMCwibWVzc2FnZSI6IlN1Y2Nlc3MiLCJkYXRhIjp7ImlkIjoyNzUsImhvc3BpdGFsX2lkIjoxLCJwYXNzd29yZCI6IiQyeSQxMCRLUGZ0d294bUFxejFkSzduXC9tZjFaLlNldmFlM1wvbFhJSFVHOUMuNVJvOEZpRzNncmxRUXZlIiwiZW1haWwiOiJhaS5icmFrZXJAZGFpbHlkb2MuY29tIiwiZmlyc3RuYW1lIjoiQWkiLCJsYXN0bmFtZSI6IkJyYWtlciIsImVtcGxveWVlX3JvbGUiOiJEb2N0b3IiLCJkZXNpZ25hdGlvbiI6IkNoYWlyIE9mIFRoZSBEZXBhcnRtZW50IiwiZW1wbG95ZWVfcm9sZV9zaG9ydCI6IkRSIiwiZGVwYXJ0bWVudCI6IkRlbnRpc3RyeSIsInRpdGxlIjoiIiwicXVhbGlmaWNhdGlvbiI6Ik1EIiwicGhvdG8iOiJodHRwczpcL1wvZGFpbHlkb2NhcHAuY29tXC9hZG1pblwvaW1nXC9kZWZhdWx0LnBuZyIsIm9mZmljZV9udW1iZXIiOiI2MTIyNzMzMDU0IiwiY2VsbF9udW1iZXIiOiI2MTI2MzY4ODU0IiwiZmF4X251bWJlciI6IjYxMjI3NTEwNTQiLCJwYWdlcl9udW1iZXIiOiIiLCJ3b3JraW5nX3RpbWUiOiIiLCJhcHBfdG9rZW4iOiIwMGViYjMyMGRjODg4ZDM0M2RkMDhlNGQ4YzNmYTk4ODE1MzUzNjgxNTkiLCJpc193b3JraW5nIjowLCJkZXZpY2VfdG9rZW4iOiI3ODAyNzczYjViM2Y0NmY1NDY5ODUzYTI2OGEwYmI4YzE0OTMyODc1MjIiLCJkZXZpY2VfdHlwZSI6MSwiYnVpbGRfdmVyc2lvbiI6IjEuMC4wIiwic3RhdHVzIjp0cnVlLCJpc19ub3RpZmljYXRpb24iOnRydWUsImhvc3BpdGFsc19lbXBsb3llZXMiOlt7ImVtcGxveWVlX2lkIjoyNzUsImhvc3BpdGFsX2lkIjotMSwic2VydmljZV90ZWFtX2lkIjotMX1dLCJwYXNzd29yZF9leHBpcmVkIjpmYWxzZSwiZGVwYXJ0bWVudF9pZCI6MTQwLCJlbXBsb3llZV9pZCI6Mjc1LCJwaG90b19uYW1lIjoiIiwicGhvdG9fdGh1bWIiOiJodHRwczpcL1wvZGFpbHlkb2NhcHAuY29tXC9hZG1pblwvaW1nXC9kZWZhdWx0LnBuZyJ9fQ.zIHwz0wpt1XACSjexHBNTILftuKwbKYe9Cc4X2j5qcY"
}

									</code>
								</pre>
						 	</div>

						 	<br>

						 	<div class="bs-callout bs-callout-danger">
								<h4 class="colorred">Bad Response</h4>
								<pre style="background-color:inherit;border:none;">
{
    "encript": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdGF0dXMiOjQwMCwibWVzc2FnZSI6IkludmFsaWQgaGVhZGVyIHBhc3NlZC4ifQ.Y4Jeb0RFe89kh4-G4rD7HWG_kbAcET5o4uFE8W9-_ZA"
}
{
    "encript": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdGF0dXMiOjQwMSwibWVzc2FnZSI6IllvdSBhcmUgdW5hdXRob3JpemVkIHRvIGFjY2VzcyB0aGlzIGxvY2F0aW9uLiJ9.As058aErTIv1Jbqnj4w5MdMzTvshS411w7ZoHc3Te_M"
}
{
    "encript": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdGF0dXMiOjQwMCwibWVzc2FnZSI6Imluc3VmZmljaWVudCBwYXJhbWV0ZXJzIn0.HEqSL2ckJ8hlCAbLKIVYmzM2bdKkXKPbVNC3LsA5R7I"
}
{
    "encript": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdGF0dXMiOjQwMywibWVzc2FnZSI6ImZvcmJpZGRlbiJ9.AvSXtHClYOacV0aDAJrERaLbWuvNcJZzMJuI_fhFcIA"
}
{
    "encript": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdGF0dXMiOjUwMCwibWVzc2FnZSI6IkludmFsaWQgdXNlci4ifQ.aOJxb_WzKSHL-938LYG-jzT9gx_MWgZ_q1VyiG6QgBE"
}
									<p class="colorred">* MESSAGE Showing Cause OF Issue In Human Readable Format</p>
								</pre>
					 		</div>