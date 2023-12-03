

    /*==============================================================*/
    /* DBMS name:      MySQL 5.0                                    */
    /* Created on:     04/03/2023 12:59:13                          */
    /*==============================================================*/

    drop table if exists Arena;

    drop table if exists Award;

    drop table if exists CPU;

    drop table if exists Computer;

    drop table if exists GPU;

    drop table if exists Game;

    drop table if exists GameGenre;

    drop table if exists Genre;

    drop table if exists Host;

    drop table if exists Player;

    drop table if exists Sponsor;

    drop table if exists SponsorAward;

    drop table if exists Team;

    drop table if exists TeamSponsor;

    drop table if exists TeamTournament;

    drop table if exists Tournament;

    drop table if exists TournamentHost;

    /*==============================================================*/
    /* Table: Arena                                                 */
    /*==============================================================*/
    create table Arena
    (
       id_arena             int not null AUTO_INCREMENT,
       arena_name           text not null,
       city                 text not null,
       country              text not null,
       primary key (id_arena)
    );

    /*==============================================================*/
    /* Table: Award                                                 */
    /*==============================================================*/
    create table Award
    (
       id_award             int not null AUTO_INCREMENT,
       unique_tag           varchar(64) not null,
       id_tournament        int not null,
       award_name           text not null,
       award_type           text not null,
       primary key (id_award)
    );

    /*==============================================================*/
    /* Table: CPU                                                   */
    /*==============================================================*/
    create table CPU
    (
       cpu_model            varchar(64) not null,
       cpu_manufacturer     text not null,
       primary key (cpu_model)
    );

    /*==============================================================*/
    /* Table: Computer                                              */
    /*==============================================================*/
    create table Computer
    (
       id_computer          int not null AUTO_INCREMENT,
       cpu_model            varchar(64) not null,
       gpu_model            varchar(64) not null,
       ram_gb               int not null,
       ip_address           text not null,
       primary key (id_computer)
    );

    /*==============================================================*/
    /* Table: GPU                                                   */
    /*==============================================================*/
    create table GPU
    (
       gpu_model            varchar(64) not null,
       gpu_manufacturer     text not null,
       primary key (gpu_model)
    );

    /*==============================================================*/
    /* Table: Game                                                  */
    /*==============================================================*/
    create table Game
    (
       id_game              int not null AUTO_INCREMENT,
       game_title           text not null,
       year                 year(4) not null,
       publisher            text not null,
       primary key (id_game)
    );

    /*==============================================================*/
    /* Table: GameGenre                                          */
    /*==============================================================*/
    create table GameGenre
    (
       id_genre             int not null,
       id_game              int not null,
       primary key (id_genre, id_game)
    );

    /*==============================================================*/
    /* Table: Genre                                                 */
    /*==============================================================*/
    create table Genre
    (
       id_genre             int not null AUTO_INCREMENT,
       genre_name           text not null,
       primary key (id_genre)
    );

    /*==============================================================*/
    /* Table: Host                                                  */
    /*==============================================================*/
    create table Host
    (
       id_host              int not null AUTO_INCREMENT,
       host_name            text not null,
       host_surname         text not null,
       gender               enum('M', 'F') not null,
       jmbg                 varchar(13) not null,
       years_experience     int not null,
       primary key (id_host)
    );

    /*==============================================================*/
    /* Table: Player                                                */
    /*==============================================================*/
    create table Player
    (
       ign                  varchar(64) not null,
       unique_tag           varchar(64) not null,
       player_name          text not null,
       player_surname       text not null,
       player_gender        enum ('M', 'F') not null,
       age                  int not null,
       primary key (ign)
    );

    /*==============================================================*/
    /* Table: Sponsor                                               */
    /*==============================================================*/
    create table Sponsor
    (
       id_sponsor           int not null AUTO_INCREMENT,
       sponsor_name         text not null,
       primary key (id_sponsor)
    );

    /*==============================================================*/
    /* Table: SponsorAward                                       */
    /*==============================================================*/
    create table SponsorAward
    (
       id_sponsor           int not null,
       id_award             int not null,
       primary key (id_sponsor, id_award)
    );

    /*==============================================================*/
    /* Table: Team                                                  */
    /*==============================================================*/
    create table Team
    (
       unique_tag           varchar(64) not null,
       id_computer          int not null,
       team_name            text not null,
       est_year             year(4) not null,
       primary key (unique_tag)
    );

    /*==============================================================*/
    /* Table: TeamSponsor                                        */
    /*==============================================================*/
    create table TeamSponsor
    (
       id_sponsor           int not null,
       unique_tag           varchar(64) not null,
       primary key (id_sponsor, unique_tag)
    );

    /*==============================================================*/
    /* Table: TeamTournament                                     */
    /*==============================================================*/
    create table TeamTournament
    (
       id_tournament        int not null AUTO_INCREMENT,
       unique_tag           varchar(64) not null,
       primary key (id_tournament, unique_tag)
    );

    /*==============================================================*/
    /* Table: Tournament                                            */
    /*==============================================================*/
    create table Tournament
    (
       id_tournament        int not null AUTO_INCREMENT,
       id_arena             int not null,
       id_game              int not null,
       tournament_name      text not null,
       primary key (id_tournament)
    );

    /*==============================================================*/
    /* Table: TournamentHost                                     */
    /*==============================================================*/
    create table TournamentHost
    (
       id_host              int not null,
       id_tournament        int not null,
       primary key (id_host, id_tournament)
    );

    alter table Award add constraint FK_TeamAward foreign key (unique_tag)
          references Team (unique_tag) on delete restrict on update restrict;

    alter table Award add constraint FK_TournamentAward foreign key (id_tournament)
          references Tournament (id_tournament) on delete restrict on update restrict;

    alter table Award add constraint FK_AwardTeamTournament foreign key (id_tournament, unique_tag)
            references TeamTournament (id_tournament, unique_tag) on delete restrict on update restrict;

    alter table Computer add constraint FK_CPUComputer foreign key (cpu_model)
          references CPU (cpu_model) on delete restrict on update restrict;

    alter table Computer add constraint FK_GPUComputer foreign key (gpu_model)
          references GPU (gpu_model) on delete restrict on update restrict;

    alter table GameGenre add constraint FK_GameGenre foreign key (id_genre)
          references Genre (id_genre) on delete restrict on update restrict;

    alter table GameGenre add constraint FK_GameGenre2 foreign key (id_game)
          references Game (id_game) on delete restrict on update restrict;

    alter table Player add constraint FK_TeamPlayer foreign key (unique_tag)
          references Team (unique_tag) on delete restrict on update restrict;

    alter table SponsorAward add constraint FK_SponsorAward foreign key (id_sponsor)
          references Sponsor (id_sponsor) on delete restrict on update restrict;

    alter table SponsorAward add constraint FK_SponsorAward2 foreign key (id_award)
          references Award (id_award) on delete restrict on update restrict;

    alter table Team add constraint FK_TeamComputer foreign key (id_computer)
          references Computer (id_computer) on delete restrict on update restrict;

    alter table TeamSponsor add constraint FK_TeamSponsor foreign key (id_sponsor)
          references Sponsor (id_sponsor) on delete restrict on update restrict;

    alter table TeamSponsor add constraint FK_TeamSponsor2 foreign key (unique_tag)
          references Team (unique_tag) on delete restrict on update restrict;

    alter table TeamTournament add constraint FK_TeamTournament foreign key (id_tournament)
          references Tournament (id_tournament) on delete restrict on update restrict;

    alter table TeamTournament add constraint FK_TeamTournament2 foreign key (unique_tag)
          references Team (unique_tag) on delete restrict on update restrict;

    alter table Tournament add constraint FK_ArenaTournament foreign key (id_arena)
          references Arena (id_arena) on delete restrict on update restrict;

    alter table Tournament add constraint FK_GameTournament foreign key (id_game)
          references Game (id_game) on delete restrict on update restrict;

    alter table TournamentHost add constraint FK_TournamentHost foreign key (id_host)
          references Host (id_host) on delete restrict on update restrict;

    alter table TournamentHost add constraint FK_TournamentHost2 foreign key (id_tournament)
          references Tournament (id_tournament) on delete restrict on update restrict;

