<style type="text/css">
.grid-container {
  display: grid;
  grid-template-columns: auto auto;
  grid-gap: 5px;
  background-color: #fff;
	padding: 5px;
	border: 0px solid black;
	margin: -30px 0px -50px 0px;
}
.grid-container > div {
  background-color: rgba(255, 255, 255, 0.8);
  border: 0px solid black;
  text-align: center;
	font-size: 20px;
	margin-top: -40px;
	height: 100%;
}
.table {
	margin-top: -30px;
	width: 100%;
}
.table td, .table th {
    padding: .374rem;
    vertical-align: top;
    border-top: 1px solid #dee2e6;
}
.card {
	height: 330px;
	width: 100%;
	border: 0px solid black;
}
.card-body {
	width: 100%;
}
.number_format {
	font-size: 12px;
}
tr {
	height: 10px !important;
	color: #fff;
}
.CARD {
	background-color: #2996cc;

}
.OTHER {
	height: 10px !important;
	background-color: #71767b;
}
.CASH {
	background-color: #24b324;
}

.total {
	height: 10px !important;
	background-color: #000000;
}
.card-title{
	font-weight: bold;
	font-size: 100%;
}
.row-title {
	text-align: left;
	font-weight: bold;
}
.data {
	text-align: center;
	font-size: 25px;
}

.backs{
	background-color: #69d169;
}



.backs1{
	background-color: #69d169;
}


</style>
<div class="grid-container">
	<div class="row">
		<div class="col">
			<div class="card" style="cursor: pointer" onclick="aldia()">
				<div class="card-body">
					<h5 class="card-title">Total Pending</h5>
					<div class="backs" style="height:12rem; padding-top: 5%; padding-bottom: 5%; color: #ffffff">
						<center>
							<p onclick="aldia()" style="font-size: 200%!important" class="data"><?php echo '$ ' . number_format($suma, 2, '.', ','); ?></p>
							<p class='card-title'>Upcoming Payments for today</p>
						</center>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col">
			<div class="card" style="cursor: pointer" onclick="go_sign_today()">
				<div class="card-body">
					<h5 class="card-title" onclick="go_sign_today()">Total Amount Signed This Week</h5>
					<div class="backs" style="background-color: #2996cc; height:12rem; padding-top: 5%; padding-bottom: 5%; color: #fff">
						<center>
							<p class="data"  style="font-size: 200%!important" onclick="go_sign_today()"><?php echo '$ ' . number_format($sing_today[0]->mountly, 2, '.', ','); ?></p>
							<p class='card-title'><?php echo $sing_today[0]->total ?> Contracts</p>
						</center>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col">
			<div class="card" style="cursor: pointer">
				<div class="card-body">
					<h5 class="card-title">Payment Methods</h5>
					<div style="background-color: #fff; height:12rem; padding-top: 5%; padding-bottom: 5%; color: #fff">
						<table class="table">
							<tbody>
								<?php foreach ($paymentMethod as $method) {?>
									<tr class="<?php echo $method->type ?>">
										<th class='row-title'><?php echo $method->type ?></th>
										<td class="data"><?php echo '$ ' . number_format($method->total, 2, '.', ','); ?></td>
									</tr>
								<?php }
$total = 0;
foreach ($paymentMethod as $key => $value) {
    if (isset($value->total)) {
        $total += $value->total;
    }

}?>
								<tr class="total">
									<th class='row-title'>TOTAL</th>
									<td class="data"><?php echo '$ ' . number_format($total, 2, '.', ','); ?></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col">
			<div class="card" style="cursor: pointer" onclick="monthly_bills()">
				<div class="card-body">
					<h5 class="card-title" onclick="monthly_bills()">Invoices</h5>
					<div class="backs1" style="height:12rem; padding-top: 5%; padding-bottom: 5%; color: #fff">
						<center>
							<p class="data"  style="font-size: 200%!important" onclick="monthly_bills()"><?php echo '$ ' . number_format($invoicessumar, 2, '.', ','); ?></p>
							<p class='card-title'>Overdue Invoices</p>
							<!--<button class="btn btn-light" >Send a reminder</button>-->
						</center>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col">
			<div class="card" onclick="contracts()" style="cursor: pointer" onclick="contracts()">
				<div class="card-body">
					<h5 class="card-title" onclick="contracts()">Contracts</h5>
					<div style="background-color: #fff; height:12rem; padding-top: 5%; padding-bottom: 5%; color: #fff">
					<table class="table">
						<tbody>
							<tr class="CARD">
								<td class='row-title'>Cancel</td>
								<td class="data"><?php echo $cancel[0]->total; ?></td>
							</tr>
							<tr class="CASH">
								<td class='row-title'>Active</td>
								<td class="data"><?php echo $active[0]->total; ?></td>
							</tr>
							<tr class="OTHER">
								<td class='row-title'>Pending / Hold</td>
								<td class="data"><?php echo $hold[0]->total; ?></td>
							</tr>
							<tr class="total">
								<td class='row-title'>Paid in Full</td>
								<td class="data"><?php echo $paid[0]->total; ?></td>
							</tr>
						</tbody>
					</table>
					</div>
				</div>
			</div>
		</div>
	</div>
  <div class="col">
    <div class="card" onclick="reminders()" style="cursor: pointer">
      <div class="card-body">
        <h5 class="card-title">Reminders</h5>
        <div style="background-color: #fff; height:12rem; padding-top: 5%; padding-bottom: 5%; color: #fff">
					<table class="table">
						<tbody>
							<tr class="CARD">
								<td class='row-title'>Today</td>
								<td class="data"><?php echo $sumadia[0]->suma; ?></td>
							</tr>
							<tr class="CASH">
								<td class='row-title'>This Week</td>
								<td class="data"><?php echo $sumasemana[0]->suma; ?></td>
							</tr>
							<tr class="OTHER">
								<td class='row-title'>This Month</td>
								<td class="data"><?php	echo $sumames[0]->suma; ?></td>
							</tr>
						</tbody>
					</table>
        </div>
      </div>
    </div>
  </div>
</div>
</div>



<br>
<br>
<br>
<br>
<button type="button" id="ok" class="btn btn-primary" data-toggle="modal" data-target="#portfolioModal2" hidden="hidden">
  Launch demo modal
</button>

<div class="portfolio-modal modal fade" id="portfolioModal2" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="close-modal" data-dismiss="modal">
          <div class="lr">
            <div class="rl"></div>
          </div>
        </div>
        <div class="container">
          <div class="row">
            <div class="col-lg-8 mx-auto">
              <div class="modal-body">
                <!-- Project Details Go Here -->
                <h2 class="text-uppercase">Service Agreement / Terms & Conditions</h2>
                <p class="item-intro text-muted">Last Updated: Aug 26, 2020</p>
                <p><hr/></p>
                <h4>Thank you for being part of the Ez Law Pay family!</h4><br>
                <p class="text-justify">
                	EZ Law Pay has been continuously doing updates to the platform to ensure maximum benefit all its’ functions. Our goal is to guarantee that all of your legal billing arranging, and tracking continues to be top of the line. Our platform continues to offer you the appropriate tools to improve organization, thus increasing and scaling your firm operations. Your subscription includes transaction organization and tracking, future payment scheduling, generating invoices, financial reports, analytics and much more! <br><br>
  					We truly value all our members and hope that Ez Law Pay has been a great asset to your firm in managing all your financial needs. As part of the ongoing enrollment process we have placed your account in a 1 year agreement plan up to September 1, 2021 at a rate of 3.5% per transaction. This will ensure you continue to receive: <br><br>

					1.	Data Migrations <br>
					2.	World Class Support<br>
					3.	Industry Leading Security<br>
					4.	Continuous updates<br><br>
					This agreement will guarantee your rate will continue without any reflected increments during the time period specified above.<br>
					In addition, you will find below our updated Terms and Conditions, please review, and acknowledge by signature and date on the last page.   <br>
					Please do not hesitate to reach out to us at (747) 205-3022 or at any of the following emails if you need any assistance.<br>
					info@ezlawpay.com for subscription related<br>
					support@ezlawpay.com for platform support<br>

					The following terms rules your use of the software and services provided by EZ Law Pay. By registering your use of the Service (as defined below), you are accepting to be bound to the terms of this User License Agreement.<br>
				</p>
                <p class="text-justify">The following terms rules your use of the software and services provided by EZ Law Pay. By registering your use of the Service (as defined below), you are accepting to be bound to the terms of this User License Agreement.</p>
                <h4 class="text-left">1. Definitions</h4>
                <p class="text-justify">(a) “Administrator” shall mean a Subscriber (as defined in Section 1(i) with authority to designate additional Authorized Users and/or read-only user, client profiles and commit the Subscriber to additional services from EZ Law Pay.</p>
                <p class="text-justify">(b) “Agreement” shall mean this entire User License Agreement and incorporates by reference the Privacy Policy located at <a href="www.ezlawpay.com">www.ezlawpay.com</a> and the attached Exhibits.</p>
                <p class="text-justify">(c) “Authorized User” shall mean an individual subscriber or the partners, members, employees, temporary employees, and independent contractors of an organization with a subscription to the Service who have been added to the account as users.</p>
                <p class="text-justify">(d) “Confidential Information” shall mean the Content (as defined in Section 1(e)) and any information, technical data, or know-how considered proprietary or confidential by either party to this Agreement including, but not limited to, either party’s research, services, inventions, processes, specifications, designs, drawings, diagrams, concepts, marketing, techniques, documentation, source code, customer information, personally identifiable information, pricing information, procedures, menu concepts, business and marketing plans or strategies, financial information, and business opportunities disclosed by either party before or after the Effective Date of this Agreement, either directly or indirectly in any form whatsoever, including in writing, orally, machine-readable form or through access to either party’s premises.</p>
                <p class="text-justify">(e) “Content” shall mean any information you upload or post to the Service and any information provided by you to EZ Law Pay in connection with the Service, including, without limitation, information about your Authorized Users or Registered Clients, as defined in Section 1(g).</p>
                <p class="text-justify">(f) “Originating Subscriber” shall mean the Subscriber who initiated the Services offered by EZ Law Pay and is assumed by EZ Law Pay to have the sole authority to administer the subscription.</p>
                <p class="text-justify">(g) “Registered Client” means an individual who has been invited to use the client-facing features of the Service in a limited capacity as a client of an Authorized User.</p>
                <p class="text-justify">(h) “Service” shall mean any software or services provided by EZ Law Pay, including but not limited to EZ Law Pay Financial Management Software, and customer relationship management (CRM) and client intake software.</p>
                <p class="text-justify">(i) “Original Subscriber” shall refer to the purchaser of the Services provided by EZ Law Pay and shall also include any present or former agent, representative, independent contractor, employee, servant, attorney and any entity or person who had authority to act on your behalf.</p>
                <p class="text-justify">(j) “Security Emergency” shall mean a violation by Subscriber of this Agreement that (a) could disrupt (i) EZ Law Pay provision of the Service; (ii) the business of other subscribers to the Service; or (iii) the network or servers used to provide the Service; or (b) provides unauthorized third party access to the Service.</p>
                <h4 class="text-left">2. Limited License & Use of the Service</h4>
                <p class="text-justify">2.1 Original Subscriber is granted a non-exclusive, non-transferable, limited license to access and use the Service.</p>
                <p class="text-justify">2.2 EZ Law Pay does not review or pre-screen the Content and EZ Law Pay claims no intellectual property rights with respect to the Content.</p>
                <p class="text-justify">2.3 Authorized Users agree not to reproduce, duplicate, copy, sell, resell or exploit access to the Service, use of the Service, or any portion of the Service, including, but not limited to the HTML, Cascading Style Sheet (“CSS”) or any visual design elements without the express written permission from Themis.</p>
                <p class="text-justify">2.4 Authorized Users agree not to modify, reverse engineer, adapt or otherwise tamper with the Service or modify another website to falsely imply that it is associated with the Service, EZ Law Pay or any other software or service provided by EZ Law Pay.</p>
                <p class="text-justify">2.5 Authorized Users agree that they will not knowingly use the Service in any manner which may infringe copyright or intellectual property rights or in any manner which is unlawful, offensive, threatening, libelous, defamatory, pornographic, obscene or in violation of the terms of this Agreement.</p>
                <p class="text-justify">2.6 Authorized Users agree that they will not knowingly use the Service to upload, post, host, or transmit unsolicited bulk email “Spam”, short message service “SMS” messages, viruses, self-replicating computer programs “Worms” or any code of a destructive or malicious nature.</p>
                <p class="text-justify">2.7 Except for the non-exclusive license granted pursuant to this Agreement, Subscriber acknowledges and agrees that all ownership, license, intellectual property and other rights and interests in and to the Service shall remain solely with EZ Law Pay.</p>
                <p class="text-justify">2.8 Authorized Users who configure the Service to share or make available certain Content to the public, are deemed to acknowledge and agree that everyone will have access to the Content (“Public Content”). It is the responsibility of the Authorized User to determine if the Service being shared is appropriate for each Registered User. EZ Law Pay reserves the right, at any time, in its sole discretion, to take any action deemed necessary with respect to Public Content that violates the terms of this Agreement, including, but not limited to, removal of such Public Content.</p>
                <p class="text-justify">2.9 EZ Law Pay reserves the right at any time, and from time to time, to modify or discontinue, temporarily or permanently, any feature associated with the Service, with or without notice, except that EZ Law Pay shall provide Subscriber with 30-days’ notice of any modification that materially reduces the functionality of the Service. Continued use of the Service following any modification constitutes Subscriber’s acceptance of the modification.</p>
                <p class="text-justify">2.10 EZ Law Pay reserves the right to temporarily suspend access to the Service for operational purposes, including, but not limited to, maintenance, repairs or installation of upgrades, and will endeavor to provide no less than two business days’ notice prior to any such suspension. Such notice shall be provided to you in advance through by way of notification within the Service, email or other notification method deemed appropriate by EZ Law Pay. Further, EZ Law Pay shall endeavor to confine planned operational suspensions with a best effort to minimize disruption to the Subscriber but reserves the ability to temporarily suspend operations without notice at any time to complete necessary repairs. In the event of a temporary suspension, EZ Law Pay will use the same notification methods listed in this section to provide updates as to the nature and duration of any temporary suspension.</p>
                <p class="text-justify">2.11 EZ Law Pay stores all Content on redundant storage servers. The Subscriber may elect to, at a regular interval, replicate all Content associated with the subscription to a third-party storage service (“Escrow Agent”). The replicated Content (“Escrowed Data”) will be held under the terms of a separate agreement exclusively between the Subscriber and the Escrow Agent (“Escrow Agreement”). The Subscriber may also elect to replicate all Content associated with the subscription on its own storage device.</p>
                <p class="text-justify">2.12 Subscriber grants to EZ Law Pay a non-exclusive, royalty-free right during Subscriber’s use of the Service, to use the Confidential Information for the sole purpose of performing EZ Law Pay’ obligations under the Agreement in accordance with the terms of the Agreement. Such rights shall include permission for EZ Law Pay to generate and publish aggregate, anonymized reports on system usage and Content trends and type, provided they do not conflict with Section 4.1.</p>
                <p class="text-justify">2.13 EZ Law Pay uses one codebase for all jurisdictions. Subscriber is required, using settings available within the Service, to configure the Service for its own jurisdiction and to verify that the settings meet the Subscriber’s requirements. EZ Law Pay will highlight known features that may require Subscriber review.</p>
                <h4 class="text-left">3. Access to the Service</h4>
                <p class="text-justify">3.1 Subscriber is only permitted to access and use the Service if he/she is an Authorized User or a Registered Client. Authorized Users are required to provide their full legal name, a valid email address, and any other information reasonably requested by the Service.</p>
                <p class="text-justify">3.2 Each Authorized User will be provided with a unique identifier to access and use the Service (“Username”). The Username shall only be used by the Authorized User to whom it is assigned, and shall not be shared with, or used by any other person, including other Authorized Users.</p>
                <p class="text-justify">3.3 The initial Administrator shall be the Original Subscriber with authority to administer the subscription and designate additional Authorized Users and/or Administrators. Each subscription may designate multiple Authorized Users as Administrator. Any Administrator shall be deemed to have the authority to manage the subscription and any Authorized Users. The Administrator will deactivate an active Username if the Administrator wishes to terminate access to the Service for any Authorized User.</p>
                <p class="text-justify">3.4 Administrators are responsible for all use of the Service by Authorized Users on the list of active Authorized Users associated with their subscription to the Service.</p>
                <p class="text-justify">3.5 As between EZ Law Pay and the Subscriber, any Content uploaded or posted to the Service remains the property of the Subscriber. Upon Cancellation or Termination of Service as discussed in Section 10 below, EZ Law Pay shall only be responsible for the return of Content directly to the Administrator or a designated Authorized User if the Administrator is unable to be reached.</p>
                <p class="text-justify">3.6 All access to and use of the Service via mechanical, programmatic, robotic, scripted or any other automated means not provided as part of the Service is strictly prohibited.</p>
                <p class="text-justify">3.7 Authorized Users are permitted to access and use the Service using an Application Program Interface (“API”) subject to the following conditions:</p>
                <p>
                  <ol>
                    <p class="text-justify">(a) any use of the Service using an API, including use of an API through a third-party product that accesses and uses the Service, is governed by these Terms of Service;</p>
                    <p class="text-justify">(b) EZ Law Pay shall not be liable for any direct, indirect, incidental, special, consequential or exemplary damages, including but not limited to, damages for loss of profits, goodwill, use, data or other intangible losses (even if EZ Law Pay has been advised of the possibility of such damages), resulting from any use of an API or third-party products that access and use the Service via an API;</p>
                    <p class="text-justify">(c) Excessive use of the Service using an API may result in temporary or permanent suspension of access to the Service via an API. EZ Law Pay, in its sole discretion, will determine excessive use of the Service via an API, and will make a reasonable attempt to warn the Authorized User prior to suspension; and</p>
                    <p class="text-justify">(d) EZ Law Pay reserves the right at any time to modify or discontinue, temporarily or permanently, access and use of the Service via an API, with or without notice.</p>
                  </ol>
                </p>
                <h4 class="text-left">4. Confidentiality</h4>
                <p class="text-justify">4.1 Each party agrees to treat all Confidential Information as confidential and not to use or disclose such Confidential Information except as necessary to perform its obligations under this Agreement.</p>
                <p class="text-justify">4.2 EZ Law Pay and any third party vendors and hosting partners it utilizes to provide the Service shall hold Content in strict confidence and shall not use or disclose Content except (a) as required to perform their obligations under this Agreement; (b) in compliance with Section 7 of this Agreement, or (c) as otherwise authorized by you in writing.</p>
                <h4 class="text-left">5. Security and Access</h4>
                <p class="text-justify">5.1 EZ Law Pay is responsible for providing a secure method of authentication and accessing its Service. EZ Law Pay will provide mechanisms that:</p>
                <p>
                  <ol>
                    <p class="text-justify">(a) allow for user password management</p>
                    <p class="text-justify">(b) transmit passwords in a secure format</p>
                    <p class="text-justify">(c) protect passwords entered for purposes of gaining access to the Service by utilizing code that follows password management best practices.</p>
                  </ol>
                </p>
                <p class="text-justify">5.2 Subscriber will be responsible for protecting the security of usernames and passwords, or any other codes associated to the Service, and for the accuracy and adequacy of personal information provided to the Service.</p>
                <p class="text-justify">5.3 Subscriber will implement policies and procedures to prevent unauthorized use of usernames and passwords and will promptly notify EZ Law Pay upon suspicion that a username and password has been lost, stolen, compromised, or misused.</p>
                <p class="text-justify">5.4 At all times, EZ Law Pay, and any third-party vendors and hosting partners it utilizes to provide the Service, will:</p>
                <p>
                  <ol>
                    <p class="text-justify">(a) use information security best practices for transmitting and storing your Content, adhering to industry standards;</p>
                    <p class="text-justify">(b) employ information security best practices with respect to network security techniques, including, but not limited to, firewalls, intrusion detection, and authentication protocols, vulnerability and patch management;</p>
                    <p class="text-justify">(c) ensure its host facilities maintain industry standards for security and privacy; and</p>
                    <p class="text-justify">(d) within thirty (30) days of a request by Subscriber, provide Subscriber with a SSAE 16 (SOC2) audit report or industry standard successor report or a comparable description of its security measures in respect of the infrastructure used to host the Service and the Content. In order to obtain such a report, Subscriber must enter into an agreement with the third-party provider of the report.</p>
                  </ol>
                </p>
                <p class="text-justify">5.5 EZ Law Pay shall report to Subscriber, with all relevant details (except those which could prejudice the security of data uploaded by other customers), any event that Themis reasonably believes represents unauthorized access to, disclosure of, use of, or damage to Content (a “Security Breach”). EZ Law Pay shall make such report within 72 hours after learning of the Security Breach.</p>
                <p class="text-justify">5.6 In the event of a Security Breach, EZ Law Pay shall (a) cooperate with Subscriber to identify the cause of the breach and to identify any affected Content; (b) assist and cooperate with Subscriber in investigating and preventing the recurrence of the Security Breach; (c) assist and cooperate with Subscriber in any litigation or investigation against third parties that Subscriber undertake to protect the security and integrity of Content; and (d) use commercially reasonable endeavors to mitigate any harmful effect of the Security Breach.</p>
                <h4 class="text-left">6. EU Data Protection</h4>
                <p class="text-justify">The parties agree to comply with the provisions of the Data Processing Addendum set out in Exhibit B. The current Data Protection Addendum applies to EZ Law Pay Financial Management Software.<strong>These terms will be updated when EZ Law Pay is included in the DPA.</strong></p>
                <h4 class="text-left">7. Legal Compliance</h4>
                <p class="text-justify">7.1 EZ Law Pay maintains that its primary duty is to protect the Content to the extent the law allows. EZ Law Pay reserves the right to provide the Confidential Information to third parties as required and permitted by law (such as in response to a subpoena or court order), and to cooperate with law enforcement authorities in the investigation of any criminal or civil matter.
                </p>
                <p class="text-justify">If EZ Law Pay is required by law to make any disclosure of the Confidential Information that is prohibited or otherwise constrained by this Agreement, then EZ Law Pay will provide Subscriber with prompt written notice (to the extent permitted by law) prior to such disclosure so that the Subscriber may seek a protective order or other appropriate relief. Subject to the foregoing sentence, EZ Law Pay may furnish that portion (and only that portion) of the Confidential Information that it is legally compelled or otherwise legally required to disclose.</p>
                <h4 class="text-left">8. Managed Backup and Archiving</h4>
                <p class="text-justify">8.1 EZ Law Pay managed backup services must be designed to facilitate restoration of Content to the server or device from which the Content originated in the event the primary data is lost or corrupted. EZ Law Pay shall ensure recovery of lost or corrupted Content at no cost to you. Following any cancellation or termination of Service for any reason, Subscriber shall have ninety days to retrieve any and all Content.</p>
                <h4 class="text-left">9. Payment, Refunds, and Subscription Changes</h4>
                <p class="text-justify">9.1 Subscribers with paid subscriptions will provide EZ Law Pay with a valid business bank account or credit card for payment of the applicable subscription fees. All subscription fees are exclusive of all federal, state, provincial, municipal or other taxes which Subscribers agree to pay based on where the Subscriber is primarily domiciled. In addition to any fees, the Subscriber may still incur charges incidental to using the Service, for example, charges for Internet access, data roaming, and other data transmission charges.</p>
                <p class="text-justify">9.2 No refunds or credits will be issued for partial periods of service, upgrade/downgrade refunds, or refunds for periods unused with an active subscription, including, but not limited to, instances involving the removal of a Subscriber.</p>
                <p class="text-justify">9.3 There are no charges for cancelling a subscription and paying subscriptions cancelled prior to the end of their current billing cycle will not be charged again in the following cycle.</p>
                <p class="text-justify">9.4 The amount charged on the next billing cycle will be automatically updated to reflect any changes to the subscription, including upgrades or downgrades, and including the addition or removal of discounts included for the purchase of suite services. Adding Authorized User subscriptions or subscription upgrades will trigger prorated charges in the current billing cycle. Subscriber authorizes EZ Law Pay to apply updated charge amounts. Subscription changes, including downgrades, may result in loss of access to Content, features, or an increase or reduction in the amount of available capacity for Content provided by the Service.</p>
                <p class="text-justify">9.5 All prices are subject to change upon notice. Such notice may be provided by an e-mail message to the Administrator, or in the form of an announcement on the Service.</p>
                <p class="text-justify">9.6 Subscriber is responsible for paying all taxes associated with the subscription to the Service. If EZ Law Pay has the legal obligation to pay or collect taxes for which Subscriber is responsible under this section, the appropriate amount shall be charged to and paid by Subscriber, unless Subscriber provides EZ Law Pay with a valid tax exemption certificate authorized by the appropriate taxing authority.</p>
                <p class="text-justify">9.7 Any and all payments by or on account of the compensation payable under this Agreement shall be made free and clear of and without deduction or withholding for any taxes. If the Subscriber is required to deduct or withhold any taxes from such payments, then the sum payable shall be increased as necessary so that, after making all required deductions or withholdings, EZ Law Pay receives an amount equal to the sum it would have received had no such deduction or withholding been made.</p>
                <h4 class="text-left">10. Cancellation and Termination</h4>
                <p class="text-justify">10.1 Administrators are solely responsible for canceling subscriptions. An Administrator may cancel their subscription at any time by accessing the Service and calling support. For security reasons, the Administrator may be directed, within the Service, to call support to complete the cancellation. Cancellations shall not be accepted by any other means.</p>
                <p class="text-justify">10.2 EZ Law Pay in its sole discretion has the right to suspend or discontinue providing the Service to any Subscriber without notice for actions that are (a) in material violation of this Agreement and (b) create a Security Emergency.</p>
                <p class="text-justify">10.3 If (i) Authorized Users use the Service to materially violate this Agreement in a way that does not create a Security Emergency; (ii) EZ Law Pay provides Subscriber with commercially reasonable notice of this violation; (iii) EZ Law Pay uses commercially reasonable efforts to discuss and resolve the violation with Subscriber; and (iv) despite the foregoing, the violation is not resolved to EZ Law Pay reasonable satisfaction within thirty (30) days of such notice, then EZ Law Pay reserves the right to suspend access to the Service.</p>
                <p class="text-justify">10.4 As required by Section 8 above (“Managed Backup and Archiving”), upon cancellation or termination of a subscription, Content is made available to the Administrator or a designated Authorized User. Following a period of no less than ninety (90) days from the cancellation or termination of a subscription, all Content associated with such subscription will be irrevocably deleted from the Service. All Escrowed Data, if any, will continue to remain available for a period of six months upon cancellation or termination of a subscription in accordance with the terms of the Escrow Agreement.</p>
                <h4 class="text-left">11. Limitation of Liability</h4>
                <p class="text-justify">11.1 Except in the case of a violation by EZ Law Pay of its obligations under Section 4 above (“Confidentiality”), Section 5 above (“Security and Access”), and Section 8 above (“Managed Backup and Archiving”), and except as provided in Section 13.2 below (“Indemnification”), EZ Law Pay shall not be liable for and Subscriber waives the right to claim any loss, injury, claim, liability or damage of any kind resulting in any way from the Services provided to Subscriber by EZ Law Pay.</p>
                <p class="text-justify">11.2 SUBSCRIBER AGREES THAT THE LIABILITY OF EZ LAW PAY ARISING OUT OF ANY CLAIM IN ANY WAY CONNECTED WITH THE SERVICE WILL NOT EXCEED THE TOTAL AMOUNT YOU HAVE PAID FOR THE SERVICE PURSUANT TO THE AGREEMENT WITHIN THE SIX MONTH PERIOD BEFORE THE DATE THE CLAIM AROSE. SUBSCRIBER FURTHER AGREES THAT EZ LAW PAY IS NOT AND WILL NOT BE LIABLE FOR ANY SPECIAL, INDIRECT, INCIDENTAL, OR CONSEQUENTIAL DAMAGES OF ANY KIND WHATSOEVER (INCLUDING WITHOUT LIMITATION, ATTORNEY FEES) RELATING TO THIS AGREEMENT. THESE DISCLAIMERS APPLY REGARDLESS OF THE FORM OF ACTION, WHETHER IN CONTRACT, TORT (INCLUDING NEGLIGENCE), STRICT LIABILITY OR OTHERWISE, WHETHER THOSE DAMAGES ARE FORESEEABLE AND WHETHER EZ LAW PAY HAS BEEN ADVISED OF THE POSSIBILITY OF THOSE DAMAGES. THESE DISCLAIMERS ARE NOT APPLICABLE TO THE INDEMNIFICATION OBLIGATION SET FORTH IN SECTION 13.2. EACH PROVISION OF THIS AGREEMENT THAT PROVIDES FOR A LIMITATION OF LIABILITY, DISCLAIMER OF DAMAGES, OR EXCLUSION OF DAMAGES IS TO ALLOCATE THE RISKS OF THIS AGREEMENT BETWEEN THE PARTIES. THIS ALLOCATION IS REFLECTED IN THE PRICING OFFERED BY EZ LAW PAY TO SUBSCRIBER AND IS AN ESSENTIAL ELEMENT OF THE BASIS OF THE BARGAIN BETWEEN THE PARTIES. EACH OF THESE PROVISIONS IS SEVERABLE FROM AND INDEPENDENT OF ALL OTHER PROVISIONS OF THIS AGREEMENT.</p>
                <p class="text-justify">11.3 Subscriber will solely be responsible for any damage and/or loss of Content contained in Subscriber’s technology which occurs as a result of Subscriber’s electronic equipment and/or Subscriber’s computer system.</p>
                <h4 class="text-left">12. Disclaimer of Warranties</h4>
                <p class="text-justify">12.1 EZ LAW PAY HEREBY DISCLAIMS ALL WARRANTIES OF ANY KIND, WHETHER EXPRESS, IMPLIED OR STATUTORY, INCLUDING, BUT NOT LIMITED TO THE IMPLIED WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE, TITLE AND NON-INFRINGEMENT OF THIRD-PARTY RIGHTS WITH RESPECT TO ANY SERVICES PROVIDED BY THEMIS. NOTHING IN THIS SECTION 12.1 SHALL MODIFY EZ LAW PAY’S OBLIGATION TO INDEMNIFY SUBSCRIBER AS REQUIRED BY SECTION 13.2(A) OF THIS AGREEMENT (“INDEMNIFICATION”).</p>
                <p class="text-justify">12.2 EZ Law Pay makes no warranty that its services when provided to Subscriber in digital or electronic format will be compatible with Subscriber computer and/or other equipment, or that these Services will be secure or error free. Nor does EZ Law Pay make any warranty as to any results that may be obtained from the use of the Service. Nothing in this Section 12.2 shall modify EZ Law Pay obligations under Section 4 above (“Confidentiality”) or Section 5 above (“Security and Access”) or EZ Law Pay’s obligation to indemnify you as required by Section 13.2(b) of this Agreement (“Indemnification”).</p>
                <p class="text-justify">12.3 EZ Law Pay hereby disclaims all warranties of any kind related to Subscriber’s hardware or software beyond the warranties provided by the manufacturer of Subscriber’s hardware or software.</p>
                <h4 class="text-left">13. Indemnification</h4>
                <p class="text-justify">13.1 Subscriber hereby agrees to indemnify and hold harmless EZ Law Pay from and against any claim, action, proceeding, loss, liability, judgment, obligation, penalty, damage, cost or expense, including attorneys’ fees, which arise from or relate to the following:</p>
                <p>
                  <ol>
                    <p class="text-justify">a. Authorized Users’ breach of any obligation stated in this Agreement, and</p>
                    <p class="text-justify">b. Authorized Users’ negligent acts or omissions.</p>
                  </ol>
                </p>
                <p class="text-justify">EZ Law Pay will provide prompt notice to Subscriber of any indemnifiable event or loss. Subscriber will undertake, at Subscriber’s own cost, the defense of any claim, suit or proceeding with counsel reasonably acceptable to EZ Law Pay. EZ Law Pay reserves the right to participate in the defense of the claim, suit, or proceeding, at EZ Law Pay’ expense, with counsel of EZ Law Pay’ choosing.</p>
                <p class="text-justify">13.2 EZ Law Pay shall defend, indemnify and hold Subscriber harmless against any loss, damage or costs (including reasonable attorneys’ fees) in connection with claims, demands, suits, or proceedings (“Claims”) made or brought against Subscriber by a third party</p>
                <p>
                  <ol style="list-style: lower-alpha;">
                    <li>
                      <p class="text-justify">alleging that the Service, or use of the Service as contemplated hereunder, infringes a copyright, a U.S. patent issued as of the date of final execution of this Agreement, or a trademark of a third party or involves the misappropriation of any trade secret of a third party; provided, however, that Subscriber:</p>
                      <p class="text-justify">(a) promptly gives written notice of the Claim to EZ Law Pay (provided, however, that the failure to so notify shall not relieve EZ Law Pay of its indemnification obligations unless EZ Law Pay can show that it was materially prejudiced by such delay and then only to the extent of such prejudice);      </p>
                      <p class="text-justify">(b) gives EZ Law Pay sole control of the defense and settlement of the Claim (provided that EZ Law Pay may not settle any Claim unless it unconditionally releases Subscriber of all liability); and</p>
                      <p class="text-justify">(c) provides to EZ Law Pay, at EZ Law Pay’s cost, all reasonable assistance.</p>
                      <p class="text-justify">EZ Law Pay shall not be required to indemnify Subscriber in the event of:</p>
                      <p class="text-justify">(x) modification of the Service by Subscriber in conflict with Subscriber’s obligations or as a result of any prohibited activity as set forth herein to the extent that the infringement or misappropriation would not have occurred but for such modification;</p>
                      <p class="text-justify">(y) use of the Service in combination with any other product or service not provided by EZ Law Pay to the extent that the infringement or misappropriation would not have occurred but for such use; or</p>
                      <p class="text-justify">(z) use of the Service in a manner not otherwise contemplated by this Agreement to the extent that the infringement or misappropriation would not have occurred but for such use; or</p>
                    </li>
                    <li>
                      <p class="text-justify">arising out of or related to a violation by EZ Law Pay of its obligations under Section 4 above (“Confidentiality”) or Section 5 above (“Security and Access”).</p>
                    </li>



                  </ol>
                </p>
                <h4 class="text-left">14. Miscellaneous</h4>
                <p class="text-justify">14.1 Technical support and training are available to Authorized Users with active subscriptions, and is available by telephone, email as defined at <a href="www.ezlawpay.com">www.ezlawpay.com</a></p>
                <p class="text-justify">14.2 Subscriber acknowledges and agrees that EZ Law Pay may use third party vendors and hosting partners to provide the necessary hardware, software, networking, storage, and related technology required to run the Service.</p>
                <p class="text-justify">14.3 EZ Law Pay may provide the ability to integrate the Service with third party products and services that Subscriber may use at Subscriber’s option and risk. Access to and use of any third-party products and services are subject to the separate terms and conditions required by the providers of the third-party products and services. Subscriber agrees that EZ Law Pay has no liability arising from Subscriber’s use of any integrations or arising from the third-party products and services. EZ Law Pay can modify or cancel the integrations at any time without notice. For purposes of calculating downtime pursuant to Exhibit A, calculation does not include the unavailability of any integration or any third-party products or services.</p>
                <p class="text-justify">14.4 Subscriber acknowledges the risk that information and the Content stored and transmitted electronically through the Service may be intercepted by third parties. Subscriber agrees to accept that risk and will not hold EZ Law Pay liable for any loss, damage, or injury resulting from the interception of information. The Content is stored securely and encrypted. Only EZ Law Pay, with strict business reasons, may access and transfer the Content and only to provide Subscriber with the Service. EZ Law Pay will make reasonable efforts to provide notice to Subscriber prior to such access and transfer. EZ Law Pay’ actions will comply with its obligations under Sections 4 and 5 of this Agreement.</p>
                <p class="text-justify">14.5 The failure of either party to enforce any provision hereof shall not constitute or be construed as a waiver of such provision or of the right to enforce it at a later time.</p>
                <p class="text-justify">14.6 This Agreement constitutes the entire agreement between Authorized Users and EZ Law Pay and governs Authorized Users use of the Service, superseding any prior agreements between Authorized Users and EZ Law Pay (including, but not limited to, any prior versions of this agreement).</p>
                <p class="text-justify">14.7 EZ Law Pay reserves the right to amend this Agreement. In the event of material changes to the Agreement, EZ Law Pay will notify Subscribers, by email, or by other reasonable means of these changes prior to their enactment. Continued use of the Service by the Subscriber after reasonable notice will be considered acceptance of any new terms.</p>
                <p class="text-justify">14.8 Neither party may assign any of its rights or obligations hereunder, whether by operation of law or otherwise, without the prior written consent of the other party (which consent shall not be unreasonably withheld). Notwithstanding the foregoing, either party may assign this Agreement in its entirety without consent of the other party in connection with a merger, acquisition, corporate reorganization, or sale of all or substantially all of its assets provided the assignee has agreed to be bound by all of the terms of this Agreement. Any attempt by a party to assign its rights or obligations under this Agreement in breach of this Section shall be void and of no effect.</p>
                <p class="text-justify">14.9 Governing Law and Venue. This Agreement and your relationship with EZ Law Pay shall be governed exclusively by, and will be enforced, construed, and interpreted exclusively in accordance with, the laws applicable in the United Sates of America, and shall be considered to have been made and accepted in United States of America without regard to its conflict of law provisions. All disputes under this Agreement will be resolved by the courts of California, in the United States of America and Subscribers consent to the jurisdiction of and venue in such courts and waive any objection as to inconvenient forum. In any action or proceeding to enforce rights under this Agreement, the prevailing party shall be entitled to recover costs and legal fees.</p>
                <h3 class="text-left text-secondary">Exhibit A</h3>
                <h4 class="text-justify">EZ Law Pay Service Level Commitments and Support Services</h4>
                <p class="text-justify">Commencing on the date the Service to the Subscriber commences (the “Subscription Term”), EZ Law Pay will provide Service Level Commitments (“SLC”) Credits (defined in Section 3 below) and Support Services in accordance with the SLC and Support Services Terms as defined herein. In the event of any conflict between the Agreement and the Service Level Commitment and Support Services Terms, the SLC and Support Services Terms will prevail. The SLC and Support Services incorporate the definitions set forth in Section 1 of the Clio User License Agreement.</p>
                <h4 class="text-left">1. Exhibit Definitions</h4>
                <p class="text-justify">“Subscriber <strong>Core Group</strong>” means Subscriber’s employees who have been trained on the Service and who are familiar with Subscriber’s business practices.</p>
                <p class="text-justify">“Subscriber <strong>User Community</strong>” means all users who input, extract or view data in the Service, including all Registered Clients.</p>
                <p class="text-justify">“<strong>Error(s)</strong>” means the material failure of the Service to conform to its published functional specifications.</p>
                <p class="text-justify">“<strong>Procedural Issues</strong>” means those issues that are to be addressed by Subscriber through adjustment of a specific business process to accomplish work in the Service.</p>
                <p class="text-justify">“<strong>Recurring Downtime</strong>” means 4 hours per month on the third Saturday of the month from 12:00 A.M. to 4:00 A.M. PST.</p>
                <p class="text-justify">“<strong>Request</strong>” means a modification to the Service outside of the scope of the functional specifications.</p>
                <p class="text-justify">“<strong>Scheduled Available Time</strong>” means 24 hours a day, 7 days a week.</p>
                <p class="text-justify">“<strong>Scheduled Downtime</strong>” means the time period identified by Themis in which it intends to perform any planned upgrades and/or maintenance on the Service or related systems and any overrun beyond the planned completion time.</p>
                <p class="text-justify">“<strong>User Administration Support</strong>” means issues that impact the usability of the Service and are addressable through the adjustment of Registered Client’s access privileges, processes or procedures.</p>
                <h4 class="text-left">2. Scope of Service Level Commitments</h4>
                <p>
                  <ol class="text-justify">
                    <li>any modification of the Service made by any person other than EZ Law Pay;</li>
                    <li>any third-party hardware or software used by Subscriber or any Registered </li>
                    <li>the improper operation of the Service by Subscriber or Registered Clients;</li>
                    <li>the accidental or deliberate damage to, or intrusion or interference with the Service;</li>
                    <li>the use of the Service other than in accordance with any user Documentation or the reasonable instructions of EZ Law Pay;</li>
                    <li>ongoing test or training instances of the Service provided to Subscriber; or</li>
                    <li>services, circumstances or events beyond the reasonable control of EZ Law Pay, including, without limitation, any force majeure events, the performance and/or availability of local ISPs employed by Subscriber, or any network beyond the demarcation or control of EZ Law Pay.</li>
                  </ol>
                </p>
                <h4 class="text-left">3. Support Services</h4>
                <p class="text-justify">EZ Law Pay will provide support services to assist Subscriber in resolving Errors (“Support Services”). Support Services do not include (a) physical installation or removal of the API and any Documentation; (b) visits to Subscriber’s site; (c) any electrical, mechanical or other work with hardware, accessories or other devices associated with the use of the Service; (d) any work with any third party equipment, software or services; (e) any professional services (“Professional Services”) associated with the Service, including, without limitation, any custom development, or data modeling.</p>
                <p class="text-justify">EZ Law Pay will provide email and/or phone support as specified at <a href="www.ezlawpay.com">www.ezlawpay.com</a>, excluding EZ Law Pay corporate holidays and national U.S. holidays except where noted.</p>
                <h3 class="text-left text-secondary">Exhibit B</h3>
                <h4 class="text-left">EZ Law Pay Data Protection Addendum</h4>
                <p class="text-justify">To the extent that EZ Law Pay Processes any Subscriber Personal Data (each as defined below) and (i) the Subscriber Personal Data relates to individuals located in the EEA; or (ii) Subscriber is established in the EEA, the provisions of this Data Processing Addendum (“<strong>DPA</strong>”) shall apply to the processing of such Subscriber Personal Data. In the event of any conflict between the remainder of the Agreement and the DPA, the DPA will prevail.</p>
                <h4 class="text-left">1. Definitions</h4>
                <p class="text-justify">1.1. The following capitalized terms used in this DPA shall be defined as follows:</p>
                <p>
                  <ol>
                    <p class="text-justify">(a) “<strong>Controller</strong>” has the meaning given in the GDPR.</p>
                    <p class="text-justify">(b) “<strong>Data Protection Laws</strong>” means the EU General Data Protection Regulation 2016/679 (“<strong>GDPR</strong>”), any applicable national implementing legislation in each case as amended, replaced or superseded from time to time, and all applicable legislation protecting the fundamental rights and freedoms of persons and their right to privacy with regard to the Processing of Subscriber Personal Data.</p>
                    <p class="text-justify">(c) “<strong>Data Subject</strong>” has the meaning given in the GDPR.</p>
                    <p class="text-justify">(d) “<strong>Processing</strong>” has the meaning given in the GDPR, and “Process” will be interpreted accordingly.</p>
                    <p class="text-justify">(e) “<strong>Processor</strong>” has the meaning given in the GDPR.</p>
                    <p class="text-justify">(f) “<strong>Security Incident</strong>” means any confirmed accidental or unlawful destruction, loss, alteration, unauthorized disclosure of, or access to, any Subscriber Personal Data.</p>
                    <p class="text-justify">(g) “<strong>Standard Contractual Clauses</strong>” means the Standard Contractual Clauses (processors) approved by European Commission Decision C(2010)593 or any subsequent version thereof released by the European Commission (which will automatically apply).</p>
                    <p class="text-justify">(h) “<strong>Sub processor</strong>” means any Processor engaged by EZ Law Pay who agrees to receive from Themis Subscriber Personal Data.</p>
                    <p class="text-justify">(i) “<strong>Subscriber Personal Data</strong>” means the “<strong>personal data</strong>” (as defined in the GDPR) described in the Annex and any other personal data contained in the Content or that EZ Law Pay processes on Subscriber’s behalf in connection with the provision of the Service.</p>
                    <p class="text-justify">(j) “<strong>Supervisory Authority</strong>” has the meaning given in the GDPR.</p>
                  </ol>
                </p>
                <h4 class="text-left">2. Data Processing</h4>
                <p class="text-justify">2.1. The Parties acknowledge and agree that for the purpose of the Data Protection Laws, the Subscriber is the Controller and EZ Law Pay is the Processor.</p>
                <p class="text-justify">2.2 <strong>Instructions for Data Processing.</strong> EZ Law Pay will only Process Subscriber Personal Data in accordance with Subscriber’s written instructions. The parties acknowledge and agree that the Agreement (subject to any changes to the Service agreed between the parties) and this DPA shall be Subscriber’s complete and final instructions to EZ Law Pay in relation to the processing of Subscriber Personal Data.</p>
                <p class="text-justify">2.3. Processing outside the scope of this DPA or the Agreement will require prior written agreement between Subscriber and EZ Law Pay on additional instructions for Processing.</p>
                <p class="text-justify">2.4. <strong>Required consents.</strong> Where required by applicable Data Protection Laws, Subscriber will ensure that it has obtained/will obtain all necessary consents and complies with all applicable requirements under Data Protection Laws for the Processing of Subscriber Personal Data by EZ Law Pay in accordance with the Agreement.</p>
                <h4 class="text-left">3. Transfer of Personal Data</h4>
                <p class="text-justify">3.1. Authorized Sub processors. Subscriber agrees that EZ Law Pay may use the following as Sub processors to Process Subscriber Personal Data:</p>
                <table class="table table-bordered">
                  <thead class="thead-dark">
                    <tr>
                      <th>Sub processor</th>
                      <th>Description of Processing</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td style="color: #000000">Blue Host</td>
                      <td style="color: #000000">Hosting</td>
                    </tr>
                  </tbody>
                </table>
                <p class="text-justify">3.2. Subscriber agrees that EZ Law Pay may use subcontractors to fulfil its contractual obligations under the Agreement. EZ Law Pay shall notify Subscriber from time to time of the identity of any Sub processors engaged. If Subscriber (acting reasonably) objects to a new Sub processor on grounds related to the protection of Subscriber Personal Data only, then without prejudice to any right to terminate the Agreement, Subscriber may request that EZ Law Pay move the Subscriber Personal Data to another Sub processor and EZ Law Pay shall, within a reasonable time following receipt of such request, use reasonable endeavors to ensure that the original Sub processor does not Process any of the Subscriber Personal Data. If it is not reasonably possible to use another Sub processor, and Subscriber continues to object for a legitimate reason, either party may terminate the Agreement on thirty (30) days written notice. If Subscriber does not object within thirty (30) days of receipt of the notice, Subscriber is deemed to have accepted the new Sub processor.</p>
                <p class="text-justify">3.3. Save as set out in clauses 3.1 and 3.2, EZ Law Pay shall not permit, allow or otherwise facilitate Sub processors to Process Subscriber Personal Data without Subscriber’s prior written consent and unless EZ Law Pay:</p>
                <p>
                  <ol>
                    <p class="text-justify">(a) enters into a written agreement with the Sub processor which imposes equivalent obligations on the Sub processor with regard to their Processing of Subscriber Personal Data, as are imposed on EZ Law Pay under this DPA; and</p>
                    <p class="text-justify">(b) shall at all times remain responsible for compliance with its obligations under the DPA and will be liable to Subscriber for the acts and omissions of any Sub processor as if they were EZ Law Pay’s acts and omissions.</p>
                  </ol>
                </p>
                <p class="text-justify">3.4. International Transfers of Subscriber Personal Data. EZ Law Pay commits to Processing Subscriber Personal Data within the EEA. To the extent that the Processing of Subscriber Personal Data by Themis involves the export of such Subscriber Personal Data to a third party in a country or territory outside the EEA, such export shall be:</p>
                <p>
                  <ol>
                    <p class="text-justify">(i) to a country or territory ensuring an adequate level of protection for the rights and freedoms of Data Subjects as determined by the American Commission;</p>
                    <p class="text-justify">(ii) to a third party that is a member of a compliance scheme recognized as offering adequate protection for the rights and freedoms of Data Subjects as determined by the American Commission; or</p>
                    <p class="text-justify">(iii) governed by the Standard Contractual Clauses between the Subscriber as exporter and such third party as importer. For this purpose, the Subscriber appoints EZ Law Pay as its agent with the authority to complete and enter the Standard Contractual Clauses as agent for the Subscriber on its behalf.</p>
                  </ol>
                </p>
                <h4 class="text-left">4. Data Security, Audits, and Security Notifications</h4>
                <p class="text-justify">4.1 <strong>EZ Law Pay Security Obligations.</strong> EZ Law Pay will implement and maintain appropriate technical and organizational security measures to ensure a level of security appropriate to the risk, including as appropriate, the measures referred to in Article 32(1) of the GDPR.</p>
                <p class="text-justify">4.2 Upon Subscriber’s reasonable request, EZ Law Pay will make available all information reasonably necessary to demonstrate compliance with this DPA.</p>
                <p class="text-justify">4.3 <strong>Security Incident Notification.</strong> If EZ Law Pay becomes aware of a Security Incident, EZ Law Pay will (a) notify Subscriber of the Security Incident within 72 hours, (b) investigate the Security Incident and provide Subscriber (and any law enforcement or regulatory official) with reasonable assistance as required to investigate the Security Incident.</p>
                <p class="text-justify">4.4 <strong>EZ Law Pay Employees and Personnel.</strong> EZ Law Pay will treat the Subscriber Personal Data as confidential and shall ensure that any employees or other personnel have agreed in writing to protect the confidentiality and security of Subscriber Personal Data.</p>
                <p class="text-justify">4.5 <strong>Audits.</strong> EZ Law Pay will, upon Subscriber’s reasonable request and at Subscriber’s expense, allow for and contribute to audits, including inspections, conducted by Subscriber (or a third party auditor on Subscriber’s behalf and mandated by Subscriber) provided (i) such audits or inspections are not conducted more than once per year (unless requested by a Supervisory Authority); (ii) are conducted only during business hours; (iii) are conducted in a manner that causes minimal disruption to EZ Law Pay’s operations and business; and (iv) Following completion of the audit, upon request, Subscriber will promptly provide EZ Law Pay with a complete copy of the results of that audit.</p>
                <h4 class="text-left">5. Access Requests and Data Subject Rights</h4>
                <p class="text-justify">5.1 <strong>Data Subject Rights.</strong> Where applicable, and taking into account the nature of the Processing, EZ Law Pay will use reasonable endeavors to assist Subscriber by implementing appropriate technical and organizational measures, insofar as this is possible, for the fulfilment of Subscriber’s obligation to respond to requests for exercising Data Subject rights laid down in the Data Protection Laws.</p>
                <h4 class="text-left">6. Data Protection Impact Assessment and Prior Consultation</h4>
                <p class="text-justify">6.1 To the extent required under applicable Data Protection Laws, EZ Law Pay will provide Subscriber with reasonably requested information regarding its Service to enable Subscriber to carry out data protection impact assessments or prior consultations with any Supervisory Authority, in each case solely in relation to Processing of Subscriber Personal Data and taking into account the nature of the Processing and information available to Themis.</p>
                <h4 class="text-left">7. Termination</h4>
                <p class="text-justify">7.1 Deletion or return of data. Subject to 7.2 below, EZ Law Pay will, at Subscriber’s election and within 90 (ninety) days of the date of termination of the Agreement:</p>
                <p>
                  <ol>
                    <p class="text-justify">(a) make available for retrieval all Subscriber Personal Data Processed by EZ Law Pay (and delete all other copies of Subscriber Personal Data Processed by Themis following such retrieval); or</p>
                    <p class="text-justify">(b) delete the Subscriber Personal Data Processed by us.</p>
                  </ol>
                </p>
                <p class="text-justify">7.2 EZ Law Pay and its Sub processors may retain Subscriber Personal Data to the extent required by applicable laws and only to the extent and for such period as required by applicable laws and always provided that EZ Law Pay ensures the confidentiality of all such Subscriber Personal Data and shall ensure that such Subscriber Personal Data is only Processed as necessary for the purpose(s) specified in the applicable laws requiring its storage and for no other purpose.</p>
                <h4 class="text-left">8. Governing law</h4>
                <p class="text-justify">8.1 This DPA shall be governed by and construed in accordance with the laws of the United States of America. Each of the parties irrevocably submits for all purposes (including any non-contractual disputes or claims) to the non-exclusive jurisdiction of the courts in California.</p>
                <h4 class="text-left">Signature</h4>
                <p class="text-justify">Client [Kostiv & Associates P.C] agrees to abide by agreement time length and rate mentioned in page 1 and knowledges updated terms and conditions set forth on this agreement. </p>
              <!--   <p class="text-justify">Typing your name serves as your signature.</p> -->
              	 <p class="text-right">Date: <?php echo date("m") . "/" . date("d") . "/" . date("Y"); ?></p>
                <form id="aceptar">
                <div class="form-group">
    				<div class="form-check">
      					<input style="transform: scale(1.5); margin-top: 10px;" name="checkbox" class="form-check-input big-checkbox" type="checkbox" value="1" id="invalidCheck" required>
      					<label style="margin-left: 15px; margin-top: 5px;" class="form-check-label" for="invalidCheck">
       						I accept this agreement and knowlege the terms and condition
      					</label>

      					<label class="text-right"></label>

      					<br><br>

      					<center><input name="firma" id="firm" style="text-align:center; border: 0;outline: 0;border-bottom: 2px solid #000000;outline:none !important;outline-width: 0 !important;box-shadow: none;-moz-box-shadow: none;-webkit-box-shadow: none; width: 45%" type="text" class="form-control" placeholder="Print Name & Title" required="required"></center>
      						<center>(Typing your name above serves as your signature.)</center>

      					<br>

      					<center>Kostiv & Associates P.C</center>
      					<!-- <hr>
      					<center>Client</center> -->

    			</div>
  				</div>

  				<button type="submit" class="btn btn-info"> Send</button>
  				</form>
                <!-- <button class="btn btn-primary" data-dismiss="modal" type="button">
                  <i class="fas fa-times"></i>
                Close</button>  -->
                <!-- Button for smooth scrolling -->
                <span class="ir-arriba special"><img src="<?php echo base_url() ?>assets/img/ArrowUp.png" alt=""></span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


<script type="text/javascript">

	$(document).ready(function(){

	var url = "<?php echo base_url() ?>C_contracts/newterms";
	$.ajax({
           type: "POST",
           url: url,
           success: function(data)
           {

            if (data == 1) {



             }else{
                document.getElementById("ok").click();
             }
           }
       });



      $('.vamosxz').attr('id', 'down');
  $('.ir-arriba').click(function(){
    $('body, html, .portfolio-modal').animate({
      scrollTop: '0px'
    }, 300);
  });

  $(window).scroll(function(){
    if( $(this).scrollTop() > 0 ){
      $('.ir-arriba').slideDown(300);
    } else {
      $('.ir-arriba').slideUp(300);
    }
  });

  $('.portfolio-modal').scroll(function(){
    if( $(this).scrollTop() > 0 ){
      $('.ir-arriba').slideDown(300);
    } else {
      $('.ir-arriba').slideUp(300);
    }
  });


 })
function go_sign_today(){
	location.href='<?php echo base_url() ?>clients_sign_today';
}
function monthly_bills(){
	location.href='<?php echo base_url() ?>monthly_bills';
}
function reminders(){
	location.href='<?php echo base_url() ?>phone_messages';
}
function contracts(){
	location.href='<?php echo base_url() ?>contrac';
}
function aldia(){
	location.href='<?php echo base_url() ?>C_reports/aldia';
}


$("#aceptar").submit(function(e) {
      e.preventDefault(); // avoid to execute the actual submit of the form.
      var form = $("#aceptar").serialize();
      $.post( "<?php echo base_url() ?>C_contracts/acept",form, function( data ) {
        if (data==1){
            Swal.fire({
              title: 'Done!',
              text:  'The information has been sent successfully.!',
              icon:  'success'
            }).then((result) => {
                location.href = "<?php echo base_url() ?>dashboard";
             })
        }else{
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: '!'
          })
        }
      });


    });
</script>

