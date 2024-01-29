import PropTypes from 'prop-types';
// @mui
import { Grid } from '@mui/material';
import NewsfeedCard from './NewsfeedCard';

// ----------------------------------------------------------------------

NewsfeedList.propTypes = {
  newsfeeds: PropTypes.array.isRequired,
};

export default function NewsfeedList({ newsfeeds, ...other }) {
  return (
    <Grid container spacing={3} {...other}>
      {newsfeeds.map((newsfeed) => (
        <Grid key={newsfeed.id} item xs={12} sm={6} md={3}>
          <NewsfeedCard newsfeed={newsfeed} />
        </Grid>
      ))}
    </Grid>
  );
}
