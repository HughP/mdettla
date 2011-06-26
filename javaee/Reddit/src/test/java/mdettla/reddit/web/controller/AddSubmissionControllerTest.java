package mdettla.reddit.web.controller;

import static org.junit.Assert.assertEquals;
import static org.junit.Assert.assertNotNull;
import mdettla.reddit.domain.Submission;
import mdettla.reddit.service.InMemorySubmissionService;
import mdettla.reddit.service.SubmissionService;

import org.junit.Before;
import org.junit.Test;
import org.springframework.ui.ExtendedModelMap;
import org.springframework.ui.Model;

public class AddSubmissionControllerTest {

	private SubmissionService submissionService;
	private AddSubmissionController controller;

	@Before
	public void setUp() {
		submissionService = new InMemorySubmissionService();
		controller = new AddSubmissionController(submissionService);
	}

	@Test
	public void testSetupForm() {
		// prepare
		Model model = new ExtendedModelMap();
		// test
		String viewName = controller.setupForm(model);
		// verify
		Submission submission = (Submission)model.asMap().get("submission");
		assertNotNull(submission);
		assertEquals("addLinkForm", viewName);
	}

	@Test
	public void testProcessSubmit() {
		// prepare
		Submission submission = new Submission();
		submission.setTitle("foo");
		// test
		String viewName = controller.processSubmit(submission);
		// verify
		Submission expected = submissionService.findAll().iterator().next();
		assertNotNull(expected);
		assertEquals("foo", expected.getTitle());
		assertEquals("redirect:/", viewName);
	}
}