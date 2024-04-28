-- Table to store information about registered users
CREATE TABLE Users (
    UserID INT PRIMARY KEY AUTO_INCREMENT,
    Username VARCHAR(50) NOT NULL UNIQUE,
    Email VARCHAR(100) NOT NULL,
    Password VARCHAR(100) NOT NULL,
    PasswordHash VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Table to store information for auction items
CREATE TABLE Items (
    ItemID INT PRIMARY KEY AUTO_INCREMENT,
    Title VARCHAR(255) NOT NULL,
    Description TEXT,
    StartPrice DECIMAL(10, 2) NOT NULL,
    StartTime DATETIME NOT NULL,
    EndTime DATETIME NOT NULL,
    SellerID INT,
    FOREIGN KEY (SellerID) REFERENCES Users(UserID)
);

-- Table to store bids about auction items
CREATE TABLE Bids (
    BidID INT PRIMARY KEY AUTO_INCREMENT,
    ItemID INT,
    BidderID INT,
    BidAmount DECIMAL(10, 2) NOT NULL,
    BidTime DATETIME NOT NULL,
    FOREIGN KEY (ItemID) REFERENCES Items(ItemID),
    FOREIGN KEY (BidderID) REFERENCES Users(UserID)
);

-- Table to store information about the winning bid for each auction item
CREATE TABLE WinningBids (
    ItemID INT PRIMARY KEY,
    BidID INT,
    FOREIGN KEY (ItemID) REFERENCES Items(ItemID),
    FOREIGN KEY (BidID) REFERENCES Bids(BidID)
);
