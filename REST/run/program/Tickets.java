package run.program;

import org.springframework.web.bind.annotation.CrossOrigin;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestMethod;
import org.springframework.web.bind.annotation.RestController;

@RestController
public class Tickets {

    @CrossOrigin()
    @RequestMapping(value = "/tickets/getAllTickets", method = RequestMethod.GET)
    public String createProject() {
        return "Test";
    }
}
