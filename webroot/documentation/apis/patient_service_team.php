<h1 id="patient_service_team">Patient Service Team</h1>
							<!-- API URL -->
							<div class="bs-callout bs-callout-info">
								<h4><?php echo $DOC_URL ?>getPatientServiceTeam.json</h4>
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
							<h3 id="type8">Type</h3>
							<div class="bs-callout bs-callout-info">
								<h4>Type : <code>POST</code></h4>
							</div>

							<!-- REQUEST PARAMETERS -->
							<h3 id="input8">Input</h3>
							<div class="highlight boderleft">
								<pre >
									<code class="html">
Token : 00ebb320dc888d343dd08e4d8c3fa9881535368159
									</code>
									<p class="colorred">* HEADER PARAMETERS</p>
								</pre>
						 	</div>
						 	<div class="highlight boderleft">
								<pre >
									<code class="html">
token:eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJlbXBsb3llZV9pZCI6Mjc1LCJwYXRpZW50X2lkIjoxMDcsImhvc3BpdGFsX2lkIjoxfQ.wO4UjLlUDfNe9DEBNoj3_E1eM85w51EqGu4jjkyxDbc
									</code>
									<p class="colorred">* REQUEST PARAMETERS</p>
								</pre>
						 	</div>

						 	<!-- RESPONSE -->
							<h3 id="output8">Output</h3>
							<div class="highlight boderleft">
								<h4 class="colorblue">success</h4>
								<pre >
									<code class="html">
{
    "encript": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdGF0dXMiOjIwMCwibWVzc2FnZSI6IlN1Y2Nlc3MiLCJkYXRhIjp7InBhdGllbnRJZCI6IjEwNyIsImdyb3VwSWQiOiItTEt6M0N6Y01xTnQtVFREdEFlNyIsImdyb3VwTmFtZSI6IldpbGxpYW0gTG9wZXoiLCJtZW1iZXJzTGlzdCI6eyIxNCI6eyJtZW1iZXJJZCI6IjE0IiwiaXNBZG1pbiI6ZmFsc2V9fX19.DBvkufqtXA21JlhlvkhzISDYia_vFjtPFn3EItp2Pic"
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