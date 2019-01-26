package run.program;

import org.springframework.web.bind.annotation.CrossOrigin;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestMethod;
import org.springframework.web.bind.annotation.RestController;

@RestController
public class QueryHandler {

    @CrossOrigin()
    @RequestMapping(value = "/create", method = RequestMethod.GET)
    public String createProject() {
        return "Test";
    }
}
