package ms3extras;

import com.mongodb.client.MongoClient;
import com.mongodb.client.MongoClients;
import com.mongodb.client.MongoDatabase;

public class MongoConnector {

    public static MongoDatabase cinebase;
    static MongoClient mongoClient;

    public MongoConnector() {
    }

    public static void connect(String user, String pwd) {
        mongoClient = MongoClients.create();
        cinebase = mongoClient.getDatabase("cinebase");
    }
}


