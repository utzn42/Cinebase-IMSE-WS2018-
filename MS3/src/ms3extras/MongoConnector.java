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
        mongoClient = MongoClients.create("mongodb://" + user + ":" + pwd + "@host1/?authSource=db1&ssl=true");
        cinebase = mongoClient.getDatabase("cinebase");
    }
}


