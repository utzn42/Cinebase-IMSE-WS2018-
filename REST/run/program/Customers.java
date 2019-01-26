package run.program;

import com.mongodb.client.MongoCollection;
import ms3extras.MongoConnector;
import org.bson.Document;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.mongodb.repository.config.EnableMongoRepositories;
import org.springframework.web.bind.annotation.CrossOrigin;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestMethod;
import org.springframework.web.bind.annotation.RestController;

import java.util.List;

@RestController
public class Customers {

    MongoCollection<Document> collection = MongoConnector.cinebase.getCollection("customers");

    @Autowired
    public Customers(){

    }

    @CrossOrigin()
    @RequestMapping(value = "/tickets/sout", method = RequestMethod.GET)
    public String createProject() {
        return String.valueOf(collection.find());
    }
}
