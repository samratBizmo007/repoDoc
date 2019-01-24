<h1 id="provider_detail">Provider Detail</h1>
							<!-- API URL -->
							<div class="bs-callout bs-callout-info">
								<h4><?php echo $DOC_URL ?>getProviderDetail.json</h4>
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
							<h3 id="type40">Type</h3>
							<div class="bs-callout bs-callout-info">
								<h4>Type : <code>POST</code></h4>
							</div>

							<!-- REQUEST PARAMETERS -->
							<h3 id="input40">Input</h3>
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
token:eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbXBsb3llZV9pZCI6MjA0LCJkYXRlIjoiMjAxOC0wMSJ9.wZeQ26ExuPIcFhJMw_Gj2l1dWBXycqE6Aef5jaSV5AQ				
									</code>
									<p class="colorred">* REQUEST PARAMETERS</p>
								</pre>
						 	</div>

						 	<!-- RESPONSE -->
							<h3 id="output40">Output</h3>
							<div class="highlight boderleft">
								<h4 class="colorblue">success</h4>
								<pre >
									<code class="html">
{
    "encript": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdGF0dXMiOjIwMCwibWVzc2FnZSI6IlN1Y2Nlc3MiLCJkYXRhIjp7ImlkIjozNDQsImhvc3BpdGFsX2lkIjoxLCJwYXNzd29yZCI6IiQyeSQxMCRvTjhpeXY5U2Y1NG1pS2V2TklHaDBPUkJaTmh1V2U4QUkzQ0xtYU0uOHdhLk00UnBKZFhcLy4iLCJlbWFpbCI6ImtoYW5kdXJhby5raG90QGRhaWx5ZG9jLmhlYWx0aGNhcmUiLCJmaXJzdG5hbWUiOiJLaGFuZHVyYW8iLCJsYXN0bmFtZSI6Iktob3QiLCJlbXBsb3llZV9yb2xlIjoiRG9jdG9yIiwiZGVzaWduYXRpb24iOiJIb3NwaXRhbGlzdCIsImVtcGxveWVlX3JvbGVfc2hvcnQiOiJEUiIsImRlcGFydG1lbnQiOiJJbnRlcm5hbCBNZWRpY2luZSIsInRpdGxlIjoiIiwicXVhbGlmaWNhdGlvbiI6Ik1EIiwicGhvdG8iOiJodHRwczpcL1wvZGFpbHlkb2NhcHAuY29tXC9pbWdcL2VtcGxveWVlc1wvb3JpZ2luYWxcLzViNzM5ZDc2YjFjYzYuanBnIiwib2ZmaWNlX251bWJlciI6IiIsImNlbGxfbnVtYmVyIjoiNjEyNjM2ODgwNiIsImZheF9udW1iZXIiOiIiLCJwYWdlcl9udW1iZXIiOiI2MTI4OTk2MDU1Iiwid29ya2luZ190aW1lIjoiIiwiYXBwX3Rva2VuIjoiIiwiaXNfd29ya2luZyI6MCwiZGV2aWNlX3Rva2VuIjoiIiwiZGV2aWNlX3R5cGUiOjAsImJ1aWxkX3ZlcnNpb24iOiIiLCJzdGF0dXMiOnRydWUsImlzX25vdGlmaWNhdGlvbiI6dHJ1ZSwiaG9zcGl0YWxzX2VtcGxveWVlcyI6W3siZW1wbG95ZWVfaWQiOjM0NCwiaG9zcGl0YWxfaWQiOjEsInNlcnZpY2VfdGVhbV9pZCI6MTIsInNlcnZpY2VfdGVhbSI6eyJpZCI6MTIsIm5hbWUiOiJHb2xkIDIifX1dLCJwYXNzd29yZF9leHBpcmVkIjpmYWxzZSwiZGVwYXJ0bWVudF9pZCI6MTA3LCJlbXBsb3llZV9pZCI6MzQ0LCJwaG90b190aHVtYiI6Imh0dHBzOlwvXC9kYWlseWRvY2FwcC5jb21cL2ltZ1wvZW1wbG95ZWVzXC9vcmlnaW5hbFwvNWI3MzlkNzZiMWNjNi5qcGcifX0.D8MrLmYZ0KC-wKFR-VWTN6LD47M8drDMztbyYoGtmbU"
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
}								<p class="colorred">* MESSAGE Showing Cause OF Issue In Human Readable Format</p>
								</pre>
					 		</div>